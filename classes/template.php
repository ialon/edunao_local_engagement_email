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

namespace local_engagement_email;

defined('MOODLE_INTERNAL') || die;

/**
 * Helper class for engagement email templates.
 */
class template {
    public static function get_templates() {
        global $DB;

        $templates = array();
        $languages = get_string_manager()->get_list_of_translations(true);
        $types = array(
            'user_created',
            'course_created',
            'user_enrolment_created',
            'course_completed'
        );

        // Create default templates for every available language
        foreach ($languages as $langcode => $langname) {
            foreach ($types as $type) {
                $templates[$langcode][$type] = [
                    'subject' => get_string($type.':emailsubject', 'local_engagement_email'),
                    'body' => get_string($type.':emailbody', 'local_engagement_email'),
                    'langcode' => $langcode,
                    'langname' => $langname,
                    'status' => 0,
                ];
            }
        }

        // Get custom templates from database
        $customtemplates = $DB->get_records('local_engagement_email_template');

        foreach ($customtemplates as $customtemplate) {
            if (!isset($templates[$customtemplate->lang])) {
                $templates[$customtemplate->lang] = array();
            }

            $templates[$customtemplate->lang][$customtemplate->type] = [
                'subject' => $customtemplate->subject,
                'body' => $customtemplate->body,
                'status' => $customtemplate->status
            ];
        }

        return $templates;
    }
}
