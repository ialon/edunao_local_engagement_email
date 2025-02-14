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
 * Credits to Bas Brands, basbrands.nl, bas@sonsbeekmedia.nl
 * for the inspiration and the use of his code as base to develop this plugin.
 *
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

$PAGE->set_context($context);
$PAGE->set_url('/local/engagement_email/index.php');
$PAGE->set_heading($SITE->fullname);
$PAGE->set_pagelayout('admin');
$PAGE->set_title(get_string('pluginname', 'local_engagement_email'));
$PAGE->navbar->add(get_string('pluginname', 'local_engagement_email'));

$placeholder = new placeholder();

echo $OUTPUT->header();

echo \html_writer::tag('h1', get_string('availableplaceholders', 'local_engagement_email'));

echo \html_writer::tag('p', get_string('globalhelp', 'local_engagement_email'));

$categories = array(
    'welcome',
    'defaultprofile',
    'customprofile',
    'defaultcourse',
    'customcourse',
    'advanced'
);

$firstitem = true;
$placeholderhtml = \html_writer::start_div('accordion', array('id' => 'accordionPlaceholders'));

foreach ($categories as $category) {
    $placeholdertable = $placeholder->print_table($category);

    if (empty($placeholdertable)) {
        continue;
    }

    // Start card
    $placeholderhtml .= \html_writer::start_div('card');

    // Start card header
    $placeholderhtml .= \html_writer::start_div('card-header', array('id' => 'heading' . $category));

    $placeholderhtml .= \html_writer::start_tag('h2', array('class' => 'mb-0'));
    $placeholderhtml .= \html_writer::start_tag(
        'button',
        array(
            'class' => 'btn btn-link ' . ($firstitem ? '' : 'collapsed'),
            'type' => 'button',
            'data-toggle' => 'collapse',
            'data-target' => '#collapse' . $category,
            'aria-expanded' => $firstitem,
            'aria-controls' => 'collapse' . $category
        )
    );
    $placeholderhtml .= get_string($category, 'local_engagement_email');
    $placeholderhtml .= \html_writer::end_tag('button');
    $placeholderhtml .= \html_writer::end_tag('h2');

    // End card header
    $placeholderhtml .= \html_writer::end_div();

    // Start card body
    $placeholderhtml .= \html_writer::start_div(
        $firstitem ? 'collapse show' : 'collapse',
        array(
            'id' => 'collapse' . $category,
            'aria-labelledby' => 'heading' . $category,
            'data-parent' => '#accordionPlaceholders'
        )
    );

    $placeholderhtml .= \html_writer::div(
        $placeholdertable,
        'card-body'
    );

    // End card body
    $placeholderhtml .= \html_writer::end_div();

    // End card
    $placeholderhtml .= \html_writer::end_div();

    $firstitem = false;
}

$placeholderhtml .= \html_writer::end_div();

echo $placeholderhtml;

echo $OUTPUT->footer();
