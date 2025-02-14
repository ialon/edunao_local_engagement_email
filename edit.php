<?php
// This file is part of the Local Engagement Email plugin
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    local
 * @subpackage engagement_email
 * @copyright  2024 Josemaria Bolanos <josemabol@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_engagement_email;

require_once('../../config.php');

$context = \context_system::instance();

require_login();
if (!is_siteadmin()) {
    return '';
}

$type = required_param('type', PARAM_ALPHANUMEXT);
$lang = required_param('language', PARAM_ALPHANUMEXT);

$PAGE->set_context($context);
$PAGE->set_url('/local/engagement_email/edit.php', ['type' => $type, 'language' => $lang]);
$PAGE->set_heading($SITE->fullname);
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('pluginname', 'local_engagement_email'));
$PAGE->navbar->add(get_string('pluginname', 'local_engagement_email'));

$template = \local_engagement_email\template::get_template($type, $lang);

$returnurl = new \moodle_url('/admin/settings.php', array('section' => 'local_engagement_email'));
$editform = new edit_form(null, (array) $template);

if ($editform->is_cancelled()) {
    redirect($returnurl);
} else if ($data = $editform->get_data()) {
    $template->status = isset($data->status) ? $data->status : 0;
    $template->subject = $data->subject;
    $template->body = $data->body_editor['text'];

    if (!empty($template->id)) {
        $DB->update_record('local_engagement_email_template', $template);
    } else {
        $DB->insert_record('local_engagement_email_template', $template);
    }

    \core\notification::add(
        get_string('template_saved', 'local_engagement_email'),
        \core\notification::SUCCESS
    );

    redirect($returnurl);
}

echo $OUTPUT->header();

$editoroptions = array(
    'subdirs' => 0,
    'maxbytes' => 0,
    'maxfiles' => 0,
    'changeformat' => 0,
    'context' => $context,
    'noclean' => false,
    'trusttext' => false
);

$template = file_prepare_standard_editor($template, 'body', $editoroptions);
$editform->set_data($template);
$editform->display();

echo $OUTPUT->footer();
