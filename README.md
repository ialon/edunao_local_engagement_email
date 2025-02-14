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

### Sending Test Emails

To send a test email from the UI, add the `test` parameter to the URL when editing an email template. For example:
/admin/settings.php?section=local_engagement_email&test=1

This will allow you to send a test email to verify the template's content and formatting.

## Supported Events

The plugin supports the following events:

- User created
- Course created
- User enrolment created
- Course completed

## Placeholders

You can use placeholders in your email templates:

Visit /local/engagement_email/index.php to see the list of available fields

## Contact

For any questions or issues, please contact Josemaria Bolanos at josemabol@gmail.com.
