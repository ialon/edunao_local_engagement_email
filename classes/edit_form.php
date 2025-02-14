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
 * @package    local
 * @subpackage engagement_email
 * @copyright  2024 Josemaria Bolanos <josemabol@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_engagement_email;

defined('MOODLE_INTERNAL') || die;

require_once($CFG->libdir.'/formslib.php');

class edit_form extends \moodleform {

    /**
     * Form definition.
     */
    function definition() {
        $mform = $this->_form;

        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $type = $this->_customdata['type'];
        $mform->addElement('hidden', 'type');
        $mform->setType('type', PARAM_ALPHANUMEXT);

        $lang = $this->_customdata['lang'];
        $mform->addElement('hidden', 'language');
        $mform->setType('language', PARAM_ALPHANUMEXT);
        $mform->setDefault('language', $lang);

        $typename = get_string($type, 'local_engagement_email');
        $langname = $this->_customdata['langname'];
        $mform->addElement('header', 'general', get_string('edittemplate', 'local_engagement_email', ['type' => $typename, 'language' => $langname]));
        
        $mform->addElement('checkbox', 'status', get_string('enabled', 'local_engagement_email'), ' ');
        $mform->setType('status', PARAM_BOOL);
        $mform->setDefault('status', 0);
       
        $mform->addElement('text', 'subject', get_string('subject', 'local_engagement_email'),'maxlength="254" size="50"');
        $mform->addRule('subject', get_string('missingsubject', 'local_engagement_email'), 'required', null, 'client');
        $mform->setType('subject', PARAM_TEXT); 

        $mform->addElement('editor', 'body_editor', get_string('body', 'local_engagement_email'));
        $mform->addRule('body_editor', get_string('missingbody', 'local_engagement_email'), 'required', null, 'client');
        $mform->setType('body_editor', PARAM_CLEANHTML);

        $mform->addElement('static', 'placeholderhelp', '', get_string('placeholderhelp', 'local_engagement_email'));

        $this->add_action_buttons(true, get_string('savechanges'));
    }
}
