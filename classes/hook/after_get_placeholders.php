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

namespace local_engagement_email\hook;
use stdClass;

defined('MOODLE_INTERNAL') || die;

#[\core\attribute\label('Hook dispatched just before returning the array of placeholders.')]
#[\core\attribute\tags('placholders')]
final class after_get_placeholders {
    public stdClass $user;
    public stdClass $course;
    public array $placeholders;
    public string $fieldtype;

    public function __construct(stdClass $user, stdClass $course, array &$placeholders, string $fieldtype) {
        $this->user = $user;
        $this->course = $course;
        $this->placeholders = &$placeholders;
        $this->fieldtype = $fieldtype;
    }

    /**
     * Adds additional placeholders to the existing list of placeholders.
     *
     * @param array $placeholders An array of additional placeholders to be added.
     * @return void
     */
    public function add_placeholders(array $placeholders): void {
        $this->placeholders = array_merge($this->placeholders, $placeholders);
    }
}
