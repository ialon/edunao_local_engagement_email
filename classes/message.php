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

defined('MOODLE_INTERNAL') || die();


class message {
    public $template;

    public function __construct($template) {
        $this->template = $template;
    }

    /**
     * Replaces the placeholders in the given text with corresponding values.
     *
     * @param string $text The text containing the placeholders.
     * @param object $user The user object.
     * @param object $course The course object.
     * @return string The text with replaced placeholders.
     */
    public function replace_values($text, $user, $course) {
        $placeholders = new placeholder($user, $course);

        foreach($placeholders->get_placeholders('all') as $placeholder => $value) {
            if (!str_contains($text, '[[')) {
                break;
            }

            if (empty($value)) {
                $value = '';
            }

            $text = str_replace($placeholder, $value, $text);
        }

        return $text;
    }

    /**
     * Sends an email message to a user.
     *
     * @param object|null $user The user to send the email to. If null, the current user will be used.
     * @param object|null $sender The sender of the email. If null, the noreply user will be used.
     * @return void
     */
    public function send($user = null, $sender = null, $course = null) {
        global $CFG, $USER, $COURSE;

        if (empty($user)) {
            $user = $USER;
        }

        if (empty($sender)) {
            $sender = \core_user::get_noreply_user();
        }

        if (empty($course)) {
            $course = $COURSE;
        }

        $this->template->subject = $this->replace_values($this->template->subject, $user, $course);
        $this->template->body = $this->replace_values($this->template->body, $user, $course);

        email_to_user(
            $user,
            $sender,
            $this->template->subject,
            html_to_text($this->template->body),
            $this->template->body
        );
    }
}
