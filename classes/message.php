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

require_once($CFG->libdir . '/filelib.php');
require_once($CFG->dirroot . '/lib/messagelib.php');
require_once($CFG->dirroot . '/user/editlib.php');

class message {
    public $template;
    public $eventname;

    public function __construct($template, $eventname) {
        $this->template = $template;
        $this->eventname = $eventname;
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

        $context = \context_system::instance();

        if (empty($user)) {
            $user = $USER;
        }

        if (empty($sender)) {
            $sender = \core_user::get_noreply_user();
        }
        $sender->maildisplay = true;

        if (empty($course)) {
            $course = $COURSE;
        }

        $this->template->subject = $this->replace_values($this->template->subject, $user, $course);
        $body = $this->replace_values($this->template->body, $user, $course);
        $body = file_rewrite_pluginfile_urls($body, 'pluginfile.php', $context->id, 'local_engagement_email', 'body', 0);

        $options = [
            'overflowdiv' => true,
            'noclean' => true,
            'para' => false,
            'context' => $context
        ];
        $body = format_text($body, FORMAT_HTML, $options);

        // Use message provider to send the email.
        $eventdata = new \core\message\message();
        $eventdata->courseid          = $course->id;
        $eventdata->component         = 'local_engagement_email';
        $eventdata->name              = $this->eventname;
        $eventdata->userfrom          = $sender;
        $eventdata->userto            = $user;
        $eventdata->subject           = $this->template->subject;
        $eventdata->fullmessage       = html_to_text($body);
        $eventdata->fullmessageformat = FORMAT_HTML;
        $eventdata->fullmessagehtml   = $body;
        $eventdata->smallmessage      = '';
        $eventdata->notification      = 1;

        message_send($eventdata);
    }

    /**
     * Toggles the email notifications for the current user based on the given action.
     *
     * @param string $action The action to perform, either 'subscribe' or 'unsubscribe'.
     * @return bool Returns true if the operation was successful, false otherwise.
     */
    public static function toggle_notifications($action) {
        global $PAGE, $USER;

        $newstatus = 0;

        switch ($action) {
            case 'subscribe':
                $newstatus = 1;
                break;
            case 'unsubscribe':
                $newstatus = 0;
                break;
            default:
                return false;
        }

        $renderer = $PAGE->get_renderer('core', 'message');

        // We only handle the email processor. This will throw an error if email is not enabled.
        $processors = get_message_processors();
        if (!in_array('email', array_keys($processors))) {
            return false;
        }

        // Let's get the user preferences.
        $providers = message_get_providers_for_user($USER->id);
        $preferences = \core_message\api::get_all_message_preferences($processors, $providers, $USER);
        $notificationlistoutput = new \core_message\output\preferences\notification_list($processors, $providers, $preferences, $USER);
        $context = $notificationlistoutput->export_for_template($renderer);

        // Iterate over all the components and notifications to update the user preferences.
        $userpref = [];
        foreach ($context['components'] as $component) {
            foreach ($component['notifications'] as $notification) {
                $enabled = $newstatus ? ['email'] : [];
                foreach ($notification['processors'] as $notificationprocessor) {
                    if ($notificationprocessor['name'] === 'email') {
                        continue;
                    } else if ($notificationprocessor['enabled']) {
                        $enabled[] = $notificationprocessor['name'];
                    }
                }
                $userpref['preference_' . $notification['preferencekey'] . '_enabled'] = implode(',', $enabled);
            }
        }
        useredit_update_user_preference($userpref);

        return true;
    }
}
