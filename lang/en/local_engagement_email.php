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

// Settings
$string['engagement_email_enabled'] = 'Enable engagement emails';
$string['engagement_email_enabled_desc'] = 'Enable sending custom engagement emails based on events';
$string['senderaddress'] = 'Sender account';
$string['senderaddress_desc'] = 'Account to use as sender for the engagement emails';

// Management
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
$string['user_created:emailbody'] = '<p>Dear [[user:fullname]],</p>
<p>Welcome to our learning platform [[sitelink]].</p>
<p>You can now create courses with AI. Create your first course now! [[adv:coursecreatelink]]</p>
<p>You can also sign up for courses by other creators, see the catalogue <a href="[[coursecatalogurl]]">here</a>.</p>';
$string['course_created:emailsubject'] = 'Course created!';
$string['course_created:emailbody'] = '<p>Dear [[user:fullname]],</p>
<p>Well done creating a new course called [[course:fullname]].</p>
<p>Your course is ready to go! You can access it <a href="[[course:url]]">here</a>.</p>
<p>Share it with your friends/students : [[adv:coursesharelink]]</p>
<p>Create another course here: [[adv:coursecreatelink]]</p>';
$string['user_enrolment_created:emailsubject'] = 'You are now enrolled in [[course:fullname]]';
$string['user_enrolment_created:emailbody'] = '<p>Dear [[user:fullname]],</p>
<p>You are now enrolled in the course [[course:fullname]].</p>
<p>Invite your friends to join you: [[adv:coursesharelink]]</p>
<p>You can also create your own courses with AI: [[adv:coursecreatelink]]</p>
<p>Enjoy your course on [[sitelink]]!</p>';
$string['course_completed:emailsubject'] = 'You have completed the course [[course:fullname]]!';
$string['course_completed:emailbody'] = '<p>Dear [[user:fullname]],</p>
<p>You have successfully completed [[course:fullname]].</p>
<p>[[adv:certificate_cta]]</p>
<p>If you enjoyed this course, share it with your friends: [[adv:coursesharelink]]</p>
<p>You can create your own courses with AI: [[adv:coursecreatelink]]</p>
<p>And sign up for further courses, see the catalogue <a href="[[coursecatalogurl]]">here</a>.</p>';
$string['get_certificate'] = '<p>Get your certificate <a href="{$a}">here</a>.</p>';

// Form
$string['edittemplate'] = 'Editing template: "{$a->type}" ({$a->language})';
$string['enabled'] = 'Enabled';
$string['subject'] = 'Subject';
$string['body'] = 'Body';
$string['missingsubject'] = 'Subject is required';
$string['missingbody'] = 'Body is required';
$string['template_saved'] = 'Template saved';
$string['placeholderhelp'] = 'Visit <a target="_blank" href="/local/engagement_email/index.php">this page</a> to see the list of available fields';

// Placeholders
$string['availableplaceholders'] = 'Available placeholders';
$string['globalhelp'] = 'The tables on this page show the available placeholders that can be used in the message templates.
The values shown in this table are YOUR values as preview, they will be replaced by the recipients values when the welcome email is sent.';
$string['welcome'] = 'Welcome';
$string['defaultprofile'] = 'Basic user profile';
$string['customprofile'] = 'Custom profile fields';
$string['defaultcourse'] = 'Basic course information';
$string['customcourse'] = 'Custom course fields';
$string['advanced'] = 'Other fields';
$string['fieldname'] = 'Placeholder';
$string['yourvalue'] = 'Preview value';
$string['resetpass'] = 'Reset your password here';
$string['coursecatalog'] = 'Course catalogue';
$string['createcourselink'] = '<a href="/my/">Create course</a>';
$string['coursesharelink'] = '<a href="{$a->courseurl}">{$a->courseurl}</a>';


$string['privacy:metadata'] = 'This plugin only sends emails. It does not store any personal data.';


