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

defined('MOODLE_INTERNAL') || die;

global $CFG;

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_engagement_email', get_string('pluginname', 'local_engagement_email'));
    $ADMIN->add('localplugins', $settings);

    // Enable/disable email sending
    $name = 'local_engagement_email/engagement_email_enabled';
    $title = get_string('engagement_email_enabled', 'local_engagement_email');
    $description = get_string('engagement_email_enabled_desc', 'local_engagement_email');
    $setting = new admin_setting_configcheckbox($name, $title, $description, false);
    $settings->add($setting);
    
    // Select sender address from a list of the site admins
    $mainadmin = get_admin();

    $options = array();
    if ($noreply = \core_user::get_noreply_user()) {
        $options[$noreply->email] = fullname($noreply);
    }
    foreach (explode(',', $CFG->siteadmins) as $id) {
        if ($user = $DB->get_record('user', array('id' => $id, 'deleted' => 0))) {
            $options[$user->email] = fullname($user);
        }
    }

    $name = 'local_engagement_email/senderaddress';
    $title = get_string('senderaddress', 'local_engagement_email');
    $description = get_string('senderaddress_desc', 'local_engagement_email');
    $setting = new admin_setting_configselect($name, $title, $description, $mainadmin->email, $options);
    $settings->add($setting);

    // Manage email templates
    $settings->add(new \local_engagement_email\manage());
}
