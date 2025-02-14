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
 * This plugin sends users emails based on triggered events:
 * Account creation, Course creation, Enrollment in a course and Course completion.
 * Emails can be enabled/disabled, configured and support multi language.
 *
 * @package    local
 * @subpackage engagement_email
 * @copyright  2024 Josemaria Bolanos <josemabol@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('NO_OUTPUT_BUFFERING', true);

require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');

$type    = required_param('type', PARAM_ALPHANUMEXT);
$lang    = required_param('language', PARAM_ALPHANUMEXT);

$PAGE->set_url('/local/engagement_email/status.php');
$PAGE->set_context(context_system::instance());

require_admin();

$return = new moodle_url('/admin/settings.php', array('section'=>'local_engagement_email', 'test'=>1));

$template = \local_engagement_email\template::get_template($type, $lang);
$message = new \local_engagement_email\message($template);
$message->send();

redirect($return);
