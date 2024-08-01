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

global $CFG;

require_once($CFG->dirroot . '/user/profile/lib.php');
require_once($CFG->dirroot . '/user/lib.php');

/**
 * Helper class for engagement email templates.
 */
class placeholder {
    public $user;
    public $course;
    public $language;

    /**
     * Placeholder class for handling user and course data.
     */
    public function __construct($user = null, $course = null) {
        global $USER, $COURSE;

        if (empty($user)) {
            $this->user = $USER;
        } else {
            $this->user = $user;
        }

        if (empty($course)) {
            $this->course = $COURSE;
        } else {
            $this->course = $course;
        }

        $this->language = isset($this->user->lang) ? $this->user->lang : current_language();
    }

    /**
     * Retrieves the placeholders based on the specified field type.
     *
     * @param string $fieldtype The type of field to retrieve placeholders for. Default is 'all'.
     * @return array An array of placeholders.
     */
    public function get_placeholders($fieldtype = 'all') {
        global $SITE;

        $oldforcelang = force_current_language($this->language);

        $placeholders = array();

        // Welcome fields
        if ($fieldtype === 'all' || $fieldtype === 'welcome') {
            $placeholders['[[sitelink]]'] = \html_writer::link(new \moodle_url('/'), $SITE->fullname);
            $placeholders['[[sitename]]'] = $SITE->fullname;
            $placeholders['[[resetpasswordlink]]'] = \html_writer::link(
                new \moodle_url('/login/forgot_password.php'),
                get_string('resetpass', 'local_engagement_email')
            );
            $placeholders['[[coursecatalogurl]]'] = new \moodle_url('/course/index.php');
            $placeholders['[[coursecataloglink]]'] = \html_writer::link(
                new \moodle_url('/course/index.php'),
                get_string('coursecatalog', 'local_engagement_email')
            );
        }

        // Default profile fields
        if ($fieldtype === 'all' || $fieldtype === 'defaultprofile') {
            $placeholders += self::get_user_defaultprofile();
        }

        // Custom profile fields
        if ($fieldtype === 'all' || $fieldtype === 'customprofile') {
            $placeholders += self::get_user_customprofile();
        }

        // Default course fields
        if ($fieldtype === 'all' || $fieldtype === 'defaultcourse') {
            $placeholders += self::get_course_default();
        }

        // Custom course fields
        if ($fieldtype === 'all' || $fieldtype === 'customcourse') {
            $placeholders += self::get_course_custom();
        }

        // Advanced fields
        if ($fieldtype === 'all' || $fieldtype === 'advanced') {
            $placeholders += self::get_advanced();
        }

        // Dispatch hook to allow other plugins to add placeholders
        if (!PHPUNIT_TEST) {
            $hook = new \local_engagement_email\hook\after_get_placeholders($this->user, $this->course, $placeholders, $fieldtype);
            \core\hook\manager::get_instance()->dispatch($hook);
        }

        force_current_language($oldforcelang);

        return $placeholders;
    }

    /**
     * Retrieves the default profile fields for a user and their corresponding values.
     *
     * @return array An associative array of placeholders with their corresponding values.
     */
    public function get_user_defaultprofile() {
        $defaultfields = array(
            'username',
            'fullname',
            'firstname',
            'lastname',
            'email',
            'address',
            'phone1',
            'phone2',
            'icq',
            'skype',
            'yahoo',
            'aim',
            'msn',
            'department',
            'institution',
            'interests',
            'idnumber',
            'lang',
            'timezone',
            'description',
            'city',
            'url',
            'country'
        );

        $placeholders = array();

        foreach ($defaultfields as $field) {
            $value = '';

            if (isset($this->user->$field)) {
                $value = $this->user->$field;
            }

            if ($field == 'fullname') {
                $value = fullname($this->user);
            }

            if (!empty($this->user->$field) && $field == 'country') {
                $value  = get_string($this->user->country, 'countries');
            }

            $placeholders['[[user:' . $field . ']]'] = $value;
        }

        return $placeholders;
    }

    /**
     * Retrieves the custom profile fields of a user and returns them as placeholders.
     *
     * @return array An associative array of placeholders, where the keys are the field names enclosed in double square brackets ([[field]]) and the values are the corresponding field values.
     */
    public function get_user_customprofile() {
        $userinfo = profile_user_record($this->user->id);
        
        $placeholders = array();

        foreach ((array) $userinfo as $field => $value) {
            $placeholders['[[user_cf:' . $field . ']]'] = $value;
        }

        return $placeholders;
    }

    /**
     * Retrieves the default placeholders for a course.
     *
     * @return array An associative array of placeholders.
     */
    public function get_course_default() {
        $placeholders = array();

        $allowedfields = array(
            'fullname',
            'shortname',
            'idnumber',
            'summary'
        );

        $data = get_course($this->course->id);

        foreach ($allowedfields as $field) {
            if (!isset($data->$field)) {
                continue;
            }

            $placeholders['[[course:' . $field . ']]'] = $data->$field;
        }

        $placeholders['[[course:url]]'] = new \moodle_url('/course/view.php', array('id' => $this->course->id));
        $placeholders['[[course:link]]'] = \html_writer::link(
            new \moodle_url('/course/view.php', array('id' => $this->course->id)),
            $data->fullname
        );

        return $placeholders;
    }

    /**
     * Retrieves the custom field placeholders for the course.
     *
     * @return array An array of custom field placeholders, where the keys are the placeholders and the values are the corresponding field values.
     */
    public function get_course_custom() {
        $placeholders = array();

        $data = \core_course\customfield\course_handler::create()->export_instance_data_object($this->course->id);

        foreach ((array) $data as $field => $value) {
            $placeholders['[[course_cf:' . $field . ']]'] = $value;
        }

        return $placeholders;
    }

    /**
     * Returns an array of advanced placeholders.
     *
     * This function generates an array of advanced placeholders that can be used in email templates.
     * The placeholders include the current date, current time, current date and time, course create link,
     * course share link, and a placeholder for a certificate call-to-action.
     *
     * @return array An array of advanced placeholders.
     */
    public function get_advanced() {
        $placeholders = array();

        $placeholders['[[adv:currentdate]]'] = date('Y-m-d');
        $placeholders['[[adv:currenttime]]'] = date('H:i:s');
        $placeholders['[[adv:currentdatetime]]'] = date('Y-m-d H:i:s');

        $placeholders['[[adv:coursecreatelink]]'] = get_string('createcourselink', 'local_engagement_email');
        $placeholders['[[adv:coursesharelink]]'] = get_string('coursesharelink', 'local_engagement_email');
        $placeholders['[[adv:certificate_cta]]'] = self::get_certificate_cta();

        return $placeholders;
    }

    /**
     * Returns a call-to-action link for a certificate.
     *
     * @return string A call-to-action link for a certificate.
     */
    public function get_certificate_cta() {
        $mods = array();

        $courseinfo = new \course_modinfo($this->course, $this->user->id);

        if ($certificates = $courseinfo->get_instances_of('customcert')) {
            foreach ($certificates as $cert) {
                if ($cert->uservisible) {
                    $mods[] = $cert;
                }
            }
        }

        if (empty($mods)) {
            return '';
        } 

        $mod = reset($mods);
        $link = new \moodle_url('/mod/customcert/view.php?id=' . $mod->id . '&downloadown=1');

        $certificatecta = get_string('get_certificate', 'local_engagement_email', $link);

        return $certificatecta;
    }

    /**
     * Prints a table of placeholders based on the given field type.
     *
     * @param string $fieldtype The field type to retrieve placeholders for.
     * @return void
     */
    public function print_table($fieldtype): string {
        global $DB, $OUTPUT;

        $table = new \html_table();
        $table->head = array(
            get_string('fieldname', 'local_engagement_email'),
            get_string('yourvalue', 'local_engagement_email')
        );

        $placeholders = self::get_placeholders($fieldtype);

        if (empty($placeholders)) {
            return '';
        }

        foreach ($placeholders as $field => $value) {
            $table->data[] = array($field, $value);
        }

        return \html_writer::table($table);
    }
}
