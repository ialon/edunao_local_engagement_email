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
use tool_brickfield\local\areas\mod_lti\name;

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/adminlib.php');

/**
 * Special class for engagement emails management.
 */
class manage extends \admin_setting {
    /**
     * Calls parent::__construct with specific arguments
     */
    public function __construct() {
        $this->nosave = true;
        parent::__construct('engagementemailsui', get_string('manageemails', 'local_engagement_email'), '', '');
    }

    /**
     * Always returns true, does nothing
     *
     * @return true
     */
    public function get_setting() {
        return true;
    }

    /**
     * Always returns true, does nothing
     *
     * @return true
     */
    public function get_defaultsetting() {
        return true;
    }

    /**
     * Always returns '', does not write anything
     *
     * @return string Always returns ''
     */
    public function write_setting($data) {
    // do not write any setting
        return '';
    }

    /**
     * Builds the XHTML to display the control
     *
     * @param string $data Unused
     * @param string $query
     * @return string
     */
    public function output_html($data, $query='') {
        global $CFG, $OUTPUT, $DB, $PAGE;

        // Optional parameter for testing
        $test = optional_param('test', 0, PARAM_INT);

        // Display strings
        $strname      = get_string('eventname', 'local_engagement_email');
        $strlang      = get_string('language');
        $strenable    = get_string('enable');
        $strdisable   = get_string('disable');
        $stredit      = get_string('edit');
        $strtest      = get_string('test', 'local_engagement_email');

        $return = $OUTPUT->heading(get_string('available_emails_header', 'local_engagement_email'), 3, 'main', true);
        $return .= $OUTPUT->box_start('generalbox engagementemailsui');

        $table = new \html_table();
        $table->head  = array($strname, $strlang, $strenable, $stredit);
        $table->colclasses = array('leftalign', 'leftalign', 'centeralign', 'centeralign');
        $table->id = 'engagementemails';
        $table->attributes['class'] = 'admintable generaltable';
        $table->data = array();

        if ($test) {
            $table->head[] = $strtest;
            $table->colclasses[] = 'centeralign';
        }

        // Iterate through email templates and add to the display table.
        $templates = template::get_templates();
        $url = new \moodle_url('/local/engagement_email/status.php', array('sesskey'=>sesskey()));

        foreach ($templates as $lang => $types) {
            foreach ($types as $type => $template) {
                $name = get_string($type, 'local_engagement_email');

                // Hide/show links
                $class = '';
                if ($template['status']) {
                    $aurl = new \moodle_url($url, array('action'=>'disable', 'type'=>$type, 'lang'=>$lang));
                    $hideshow = "<a href=\"$aurl\">";
                    $hideshow .= $OUTPUT->pix_icon('t/hide', $strdisable) . '</a>';
                    $enabled = true;
                    $displayname = $name;
                } else {
                    $aurl = new \moodle_url($url, array('action'=>'enable', 'type'=>$type, 'lang'=>$lang));
                    $hideshow = "<a href=\"$aurl\">";
                    $hideshow .= $OUTPUT->pix_icon('t/show', $strenable) . '</a>';
                    $enabled = false;
                    $displayname = $name;
                    $class = 'dimmed_text';
                }
    
                // Add edit link
                $editurl = new \moodle_url('/local/engagement_email/edit.php', array('type'=>$type, 'lang'=>$lang));
                $edithtml = "<a href=\"$editurl\">";
                $edithtml .= $OUTPUT->pix_icon('t/edit', $stredit) . '</a>';

                $rowcontent = array($name, $template['langname'], $hideshow, $edithtml);
    
                // Add test link
                if ($test) {
                    $testurl = new \moodle_url('/local/engagement_email/test.php', array('type'=>$type, 'lang'=>$lang));
                    $testhtml = "<a href=\"$testurl\">";
                    $testhtml .= $OUTPUT->pix_icon('t/email', $strtest) . '</a>';
                    $rowcontent[] = $testhtml;
                }
    
                // Add row to the table
                $row = new \html_table_row($rowcontent);
                if ($class) {
                    $row->attributes['class'] = $class;
                }
                $table->data[] = $row;
            }
        }

        $return .= \html_writer::table($table);
        $return .= get_string('tablenosave', 'admin');
        $return .= $OUTPUT->box_end();
        return highlight($query, $return);
    }
}
