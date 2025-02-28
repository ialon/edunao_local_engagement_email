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

/**
 * Serves any files associated with local_engagement_email.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return void|bool
 */
function local_engagement_email_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = []) {
    // This code is copied and modified from core_admin_pluginfile() in admin/lib.php.
    if ($context->contextlevel == CONTEXT_SYSTEM && $filearea === 'body') {
        global $CFG;

        require_once("$CFG->libdir/filelib.php");

        $syscontext = context_system::instance();
        $component = 'local_engagement_email';

        $revision = array_shift($args);
        if ($revision < 0) {
            $lifetime = 0;
        } else {
            $lifetime = 60*60*24*60;
            // By default, theme files must be cache-able by both browsers and proxies.
            if (!array_key_exists('cacheability', $options)) {
                $options['cacheability'] = 'public';
            }
        }

        $fs = get_file_storage();
        $relativepath = implode('/', $args);

        $fullpath = "/{$syscontext->id}/{$component}/{$filearea}/0/{$relativepath}";
        $fullpath = rtrim($fullpath, '/');

        if ($file = $fs->get_file_by_hash(sha1($fullpath))) {
            send_stored_file($file, $lifetime, 0, $forcedownload, $options);
            return true;
        } else {
            send_file_not_found();
        }
    } else {
        send_file_not_found();
    }
}

/**
 * This function adds a link to the user's profile navigation allowing them to
 * subscribe or unsubscribe from email notifications. The link is only shown
 * if the user is viewing their own profile and if the email message processor
 * is enabled.
 *
 * @param core_user\output\myprofile\tree $tree The profile navigation tree.
 * @param stdClass $user The user whose profile is being viewed.
 * @param bool $iscurrentuser Whether the profile being viewed belongs to the current user.
 * @param stdClass $course The course context (not used in this function).
 */
function local_engagement_email_myprofile_navigation(core_user\output\myprofile\tree $tree, $user, $iscurrentuser, $course) {
    global $PAGE, $USER;

    // Only show the category if we are viewing our own profile.
    $user = \core_user::get_user($user->id, '*', MUST_EXIST);
    if ($USER->id != $user->id) {
        return;
    }

    $renderer = $PAGE->get_renderer('core', 'message');

    // We only handle the email processor. This will throw an error if email is not enabled.
    $processors = get_message_processors();
    if (!in_array('email', array_keys($processors))) {
        return;
    }

    // Default action is to subscribe. If just one email notification is enabled, we will show the unsubscribe link.
    $action = 'subscribe';

    // Let's get the user preferences.
    $providers = message_get_providers_for_user($USER->id);
    $preferences = \core_message\api::get_all_message_preferences($processors, $providers, $USER);
    $notificationlistoutput = new \core_message\output\preferences\notification_list($processors, $providers, $preferences, $USER);
    $context = $notificationlistoutput->export_for_template($renderer);

    // Iterate over all the components and notifications to check if there is an email notification still enabled.
    foreach ($context['components'] as $component) {
        foreach ($component['notifications'] as $notification) {
            foreach ($notification['processors'] as $notificationprocessor) {
                if ($notificationprocessor['name'] === 'email'
                    && $notificationprocessor['locked'] != 1
                    && $notificationprocessor['enabled']) {
                    $action = 'unsubscribe';
                    break 3;
                }
            }
        }
    }

    $url = new \moodle_url('/local/engagement_email/unsubscribe.php', ['action' => $action]);
    $unsubscribelink = \html_writer::link($url, get_string('profile:' . $action, 'local_engagement_email'));

    // Add content to the category.
    $node = new \core_user\output\myprofile\node(
        'contact',
        'unsubscribe',
        get_string('unsubscribe:email', 'local_engagement_email'),
        null,
        null,
        $unsubscribelink
    );
    $tree->add_node($node);
}
