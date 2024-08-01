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

/**
 * This file contains the class that handles testing of events.
 *
 * @package    local_engagement_email
 * @copyright  2024 Josemaria Bolanos <josemabol@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class events_test extends \advanced_testcase {
    public $user;

    /**
     * Tests set up
     */
    protected function setUp(): void {
        $this->setAdminUser();
        $this->resetAfterTest();

        // Create user to receive the email.
        $user = $this->getDataGenerator()->create_user();
        $this->user = $user;
        $this->setUser($user);
    }

    /**
     * Test case for the email configuration
     *
     * It verifies that no email is sent when the plugin or the template is disabled
     * and that an email is sent when both are properly enabled.
     *
     */
    public function test_email_disabled_configuration() {
        // Catch the emails.
        $sink = $this->redirectEmails();

        // Create a course to trigger course_created event.
        $data = new \stdClass();
        $data->idnumber = 'idnumber1';
        $course1 = $this->getDataGenerator()->create_course($data);

        // Plugin is disabled by default. No email should be sent.
        $this->assertSame(0, $sink->count());

        // Enable the plugin and try again.
        set_config('engagement_email_enabled', 1, 'local_engagement_email');

        $data->idnumber = 'idnumber2';
        $course2 = $this->getDataGenerator()->create_course($data);

        // The engagement email for course_created is disabled by default. No email should be sent.
        $this->assertSame(0, $sink->count());

        // Enable the template for this event and try again
        template::change_status('enable', 'course_created', $this->user->lang);

        $data->idnumber = 'idnumber3';
        $course3 = $this->getDataGenerator()->create_course($data);

        // Check that exactly one email was sent.
        $this->assertSame(1, $sink->count());
        $result = $sink->get_messages();
        $this->assertCount(1, $result);
        $sink->close();
    }

    /**
     * Test that triggering a user_created event works as expected.
     */
    public function test_user_created_event() {
        global $SITE;

        $this->resetAfterTest();

        // Catch the emails.
        $sink = $this->redirectEmails();

        // Enable the plugin and template for this event
        set_config('engagement_email_enabled', 1, 'local_engagement_email');
        template::change_status('enable', 'user_created', $this->user->lang);

        // Create a user to trigger the user_created event.
        $data = new \stdClass();
        $data->username = 'username2';
        $user2 = $this->getDataGenerator()->create_user($data);

        // Check that exactly one email was sent.
        $this->assertSame(1, $sink->count());
        $result = $sink->get_messages();
        $this->assertCount(1, $result);
        $sink->close();

        // Expected values
        $sitelink = \html_writer::link(new \moodle_url('/'), $SITE->fullname);
        $coursecatalog = new \moodle_url('/course/index.php');

        // Check the email content.
        $expected = new \stdClass();
        $expected->subject = 'Welcome to ' . $SITE->fullname . '!';
        $expected->body1 = '<p>Dear ' . fullname($user2) . ',</p>';
        $expected->body2 = 'Welcome to our learning platform ' . $sitelink . '.</p>';
        $expected->body3 = '<p>You can now create courses with AI. Create your first course now! <a href="/my/">Create course</a></p>';
        $expected->body4 = '<p>You can also sign up for courses by other creators, see the catalogue <a href="' . $coursecatalog . '">here</a>.</p>';

        $this->assertSame($expected->subject, $result[0]->subject);
        $this->assertStringContainsString($expected->body1, quoted_printable_decode($result[0]->body));
        $this->assertStringContainsString($expected->body2, quoted_printable_decode($result[0]->body));
        $this->assertStringContainsString($expected->body3, quoted_printable_decode($result[0]->body));
        $this->assertStringContainsString($expected->body4, quoted_printable_decode($result[0]->body));
        $this->assertSame($user2->email, $result[0]->to);
    }

    /**
     * Test that triggering a course_created event works as expected.
     */
    public function test_course_created_event() {
        $this->resetAfterTest();

        // Catch the emails.
        $sink = $this->redirectEmails();

        // Enable the plugin and template for this event
        set_config('engagement_email_enabled', 1, 'local_engagement_email');
        template::change_status('enable', 'course_created', $this->user->lang);

        // Create a course to trigger the course_created event.
        $data = new \stdClass();
        $data->idnumber = 'idnumber1';
        $course = $this->getDataGenerator()->create_course($data);

        // Check that exactly one email was sent.
        $this->assertSame(1, $sink->count());
        $result = $sink->get_messages();
        $this->assertCount(1, $result);
        $sink->close();

        // Check the email content.
        $expected = new \stdClass();
        $expected->subject = 'Course created!';
        $expected->body1 = '<p>Dear ' . fullname($this->user) . ',</p>';
        $expected->body2 = '<p>Well done creating a new course called ' . $course->fullname . '.</p>';
        $expected->body3 = '<p>Your course is ready to go! You can access it <a href="https://www.example.com/moodle/course/view.php?id=' . $course->id . '">here</a>.</p>';
        $expected->body4 = '<p>Share it with your friends/students : <a href="/my/">TODO: Share course</a></p>';
        $expected->body5 = '<p>Create another course here: <a href="/my/">Create course</a></p>';

        $this->assertSame($expected->subject, $result[0]->subject);
        $this->assertStringContainsString($expected->body1, quoted_printable_decode($result[0]->body));
        $this->assertStringContainsString($expected->body2, quoted_printable_decode($result[0]->body));
        $this->assertStringContainsString($expected->body3, quoted_printable_decode($result[0]->body));
        $this->assertStringContainsString($expected->body4, quoted_printable_decode($result[0]->body));
        $this->assertStringContainsString($expected->body5, quoted_printable_decode($result[0]->body));
        $this->assertSame($this->user->email, $result[0]->to);
    }

    /**
     * Test that triggering a user_enrolment_created event works as expected.
     */
    public function test_user_enrolment_created_event() {
        global $SITE;

        $this->resetAfterTest();

        // Catch the emails.
        $sink = $this->redirectEmails();

        // Enable the plugin and template for this event
        set_config('engagement_email_enabled', 1, 'local_engagement_email');
        template::change_status('enable', 'user_enrolment_created', $this->user->lang);

        // Create a course and enrol the user to trigger the user_enrolment_created event.
        $data = new \stdClass();
        $data->idnumber = 'idnumber1';
        $course = $this->getDataGenerator()->create_course($data);
        $this->getDataGenerator()->enrol_user($this->user->id, $course->id);

        // Check that exactly one email was sent.
        $this->assertSame(1, $sink->count());
        $result = $sink->get_messages();
        $this->assertCount(1, $result);
        $sink->close();

        // Check the email content.
        $sitelink = \html_writer::link(new \moodle_url('/'), $SITE->fullname);

        $expected = new \stdClass();
        $expected->subject = 'You are now enrolled in ' . $course->fullname;
        $expected->body1 = '<p>Dear ' . fullname($this->user) . ',</p>';
        $expected->body2 = '<p>You are now enrolled in the course ' . $course->fullname . '.</p>';
        $expected->body3 = '<p>Invite your friends to join you: <a href="/my/">TODO: Share course</a></p>';
        $expected->body4 = '<p>You can also create your own courses with AI: <a href="/my/">Create course</a></p>';
        $expected->body5 = '<p>Enjoy your course on ' . $sitelink . '!</p>';

        $this->assertSame($expected->subject, $result[0]->subject);
        $this->assertStringContainsString($expected->body1, quoted_printable_decode($result[0]->body));
        $this->assertStringContainsString($expected->body2, quoted_printable_decode($result[0]->body));
        $this->assertStringContainsString($expected->body3, quoted_printable_decode($result[0]->body));
        $this->assertStringContainsString($expected->body4, quoted_printable_decode($result[0]->body));
        $this->assertStringContainsString($expected->body5, quoted_printable_decode($result[0]->body));
        $this->assertSame($this->user->email, $result[0]->to);
    }

    /**
     * Test that triggering a course_completed event works as expected.
     */
    public function test_course_completed_event() {
        $this->resetAfterTest();

        // Catch the emails.
        $sink = $this->redirectEmails();

        // Enable the plugin and template for this event
        set_config('engagement_email_enabled', 1, 'local_engagement_email');
        template::change_status('enable', 'course_completed', $this->user->lang);

        // Create a course and complete it to trigger the course_completed event.
        $course = $this->getDataGenerator()->create_course(['enablecompletion' => 1]);
        $this->getDataGenerator()->enrol_user($this->user->id, $course->id);
        $ccompletion = new \completion_completion(array('course' => $course->id, 'userid' => $this->user->id));
        $ccompletion->mark_complete();

        // Check that exactly one email was sent.
        $this->assertSame(1, $sink->count());
        $result = $sink->get_messages();
        $this->assertCount(1, $result);
        $sink->close();

        // Check the email content.
        $coursecatalog = new \moodle_url('/course/index.php');

        $expected = new \stdClass();
        $expected->subject = 'You have completed the course ' . $course->fullname . '!';
        $expected->body1 = '<p>Dear ' . fullname($this->user) . ',</p>';
        $expected->body2 = '<p>You have successfully completed ' . $course->fullname . '.</p>';
        $expected->body3 = '<p>If you enjoyed this course, share it with your friends: <a href="/my/">TODO: Share course</a></p>';
        $expected->body4 = '<p>You can create your own courses with AI: <a href="/my/">Create course</a></p>';
        $expected->body5 = '<p>And sign up for further courses, see the catalogue <a href="' . $coursecatalog . '">here</a>.</p>';

        $this->assertSame($expected->subject, $result[0]->subject);
        $this->assertStringContainsString($expected->body1, quoted_printable_decode($result[0]->body));
        $this->assertStringContainsString($expected->body2, quoted_printable_decode($result[0]->body));
        $this->assertStringContainsString($expected->body3, quoted_printable_decode($result[0]->body));
        $this->assertStringContainsString($expected->body4, quoted_printable_decode($result[0]->body));
        $this->assertStringContainsString($expected->body5, quoted_printable_decode($result[0]->body));
        $this->assertSame($this->user->email, $result[0]->to);
    }
}
