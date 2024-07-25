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

$string['pluginname'] = 'Engagement emails';

$string['manageemails'] = 'Manage emails';

$string['engagement_email_enabled'] = 'Enable engagement emails';
$string['engagement_email_enabled_desc'] = 'Enable sending custom engagement emails based on events';

$string['available_emails_header'] = 'Available engagement emails';
$string['resetfilters'] = 'Reset filters';
$string['eventname'] = 'Event name';
$string['test'] = 'Test';

// Supported events
$string['user_created'] = 'User created';
$string['course_created'] = 'Course created';
$string['user_enrolment_created'] = 'User enrolment created';
$string['course_completed'] = 'Course completed';

// Default templates
$string['user_created:emailsubject'] = 'Welcome to [[sitename]]!';
$string['user_created:emailbody'] = 'Dear [[fullname]],
Welcome to our learning platform [[sitelink]].
You can now create courses with AI. Create your first course now! [[genailink]]
You can also sign up for courses by other creators, see the catalogue <a href="[[coursecatalogurl]]">here</a>.';
$string['course_created:emailsubject'] = 'Course created!';
$string['course_created:emailbody'] = 'Dear [[fullname]],
Well done creating a new course called [[coursename]].
Your course is ready to go! You can access it <a href="[[courseurl]]">here</a>.
Share it with your friends/students : [[coursesharelink]]
Create another course here: [[genailink]]';
$string['user_enrolment_created:emailsubject'] = 'You are now enrolled in [[coursename]]';
$string['user_enrolment_created:emailbody'] = 'Dear [[fullname]],
You are now enrolled in the course [[coursename]].
Invite your friends to join you: [[coursesharelink]]
You can also create your own courses with AI: [[genailink]]
Enjoy your course on [[sitelink]]!';
$string['course_completed:emailsubject'] = 'You have completed the course [[coursename]]!';
$string['course_completed:emailbody'] = 'Dear [[fullname]],
You have successfully completed [[coursename]].
[[certificate_cta]]
If you enjoyed this course, share it with your friends: [[coursesharelink]]
You can create your own courses with AI: [[genailink]]
And sign up for further courses, see the catalogue <a href="[[coursecatalogurl]]">here</a>.';
$string['get_certificate'] = 'Get your certificate <a href="[[certificateurl]]">here</a>.';

$string['privacy:metadata'] = 'This plugin only sends emails. It does not store any personal data.';


