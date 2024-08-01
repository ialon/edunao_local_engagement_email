# Engagement Email Plugin

The Engagement Email Plugin allows administrators to send custom engagement emails based on specific events within the Moodle platform. This plugin provides a user-friendly interface for managing email templates and sending test emails.

## Installation

1. Download the plugin and place it in the `local/engagement_email` directory of your Moodle installation.
2. Navigate to the Site Administration > Notifications to complete the installation.

## Configuration

1. Go to Site Administration > Plugins > Local plugins > Engagement Email.
2. Enable the plugin by checking the "Enable engagement emails" option.
3. Configure the email templates as needed.

## Usage

### Managing Email Templates

1. Navigate to Site Administration > Plugins > Local plugins > Engagement Email.
2. Click on "Manage emails" to view and edit the available email templates.
3. Use the form to add or edit the subject and body of the emails. You can use placeholders to personalize the emails.

### Default subject and body
The default subject and body for the new templates are provided with language strings

- `user_created:emailsubject`           -> `user_created:emailbody`
- `course_created:emailsubject`         -> `course_created:emailbody`
- `user_enrolment_created:emailsubject` -> `user_enrolment_created:emailbody`
- `course_completed:emailsubject`       -> `course_completed:emailbody`

You could edit the language strings but once a template is modified from the UI in any way (including enabling/disabling the template) these fields are stored in the database. You can always edit these fields using the editor.

### Sending Test Emails

Real emails will not be sent if the plugin or the template for that event and language is disabled.

To send test emails immediately from the UI (ignoring if the plugin or template is disabled), add the `test` parameter to the URL when editing an email template. For example:
`/admin/settings.php?section=local_engagement_email&test=1`

This will allow you to send a test email to verify the template's content and formatting. The test emails are sent to the account you are logged in into. Also if you use any user or course placeholders your user and the main course (the site itself) are used to populate the placeholders. The intention of these emails is to test the content and structure of the email.

## Supported Events

The plugin supports the following events:

- User created
- Course created
- User enrolment created
- Course completed

These events provide the necessary context about the user and course involved in the action. This is all handled by core Moodle.

## Placeholders

You can use placeholders in your email templates:

Visit `/local/engagement_email/index.php` to see the list of available fields

So for example to use the Course URL in your template you can use: `[[course:url]]`

## Contact

For any questions or issues, please contact Josemaria Bolanos at josemabol@gmail.com.
