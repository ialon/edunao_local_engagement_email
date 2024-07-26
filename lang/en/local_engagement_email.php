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
$string['user_created:emailbody'] = '<p>Dear [[fullname]],</p>
<p>Welcome to our learning platform [[sitelink]].</p>
<p>You can now create courses with AI. Create your first course now! [[genailink]]</p>
<p>You can also sign up for courses by other creators, see the catalogue <a href="[[coursecatalogurl]]">here</a>.</p>';
$string['course_created:emailsubject'] = 'Course created!';
$string['course_created:emailbody'] = '<p>Dear [[fullname]],</p>
<p>Well done creating a new course called [[coursename]].</p>
<p>Your course is ready to go! You can access it <a href="[[courseurl]]">here</a>.</p>
<p>Share it with your friends/students : [[coursesharelink]]</p>
<p>Create another course here: [[genailink]]</p>';
$string['user_enrolment_created:emailsubject'] = 'You are now enrolled in [[coursename]]';
$string['user_enrolment_created:emailbody'] = '<p>Dear [[fullname]],</p>
<p>You are now enrolled in the course [[coursename]].</p>
<p>Invite your friends to join you: [[coursesharelink]]</p>
<p>You can also create your own courses with AI: [[genailink]]</p>
<p>Enjoy your course on [[sitelink]]!</p>';
$string['course_completed:emailsubject'] = 'You have completed the course [[coursename]]!';
$string['course_completed:emailbody'] = '<p>Dear [[fullname]],</p>
<p>You have successfully completed [[coursename]].</p>
<p>[[certificate_cta]]</p>
<p>If you enjoyed this course, share it with your friends: [[coursesharelink]]</p>
<p>You can create your own courses with AI: [[genailink]]</p>
<p>And sign up for further courses, see the catalogue <a href="[[coursecatalogurl]]">here</a>.</p>';
$string['get_certificate'] = '<p>Get your certificate <a href="[[certificateurl]]">here</a>.</p>';

// Form
$string['edittemplate'] = 'Editing template: "{$a->type}" ({$a->language})';
$string['enabled'] = 'Enabled';
$string['subject'] = 'Subject';
$string['body'] = 'Body';
$string['missingsubject'] = 'Subject is required';
$string['missingbody'] = 'Body is required';
$string['template_saved'] = 'Template saved';
$string['placeholderhelp'] = 'Visit <a target="_blank" href="/local/engagement_email/index.php">this page</a> to see the list of available fields';


$string['privacy:metadata'] = 'This plugin only sends emails. It does not store any personal data.';


