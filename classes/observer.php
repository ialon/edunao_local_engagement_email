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

class observer {
    /**
     * Send email to user
     * 
     * @param \core\event\base $event
     */
    public static function prepare_email(\core\event\base $event) {
        global $CFG, $SITE;

        $eventname = get_class($event);

        $allowedevents = array(
            'core\event\user_created',
            'core\event\course_created',
            'core\event\user_enrolment_created',
            'core\event\course_completed'
        );

        if (!in_array($eventname, $allowedevents)) {
            return;
        }

        $eventdata = $event->get_data();

        $user = \core_user::get_user($eventdata['objectid']);

        $sender = get_admin();

        // Sender can be false when unit tests are running.
        if ($sender === false) {
            return;
        }

        if (!empty($user->email)) {
            $config = get_config('local_engagement_email');

            if ($config->disabled) {
                return;
            }

            // TODO: send email to user
        }
    }
}

