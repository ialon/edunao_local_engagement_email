<?php

/**
 * Message Providers for engagement emails.
 *
 * @package    local_engagement_email
 * @copyright  2025 Josemaria Bolanos <admin@mako.digital>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$messageproviders = array (
    // New user account created.
    'user_created'   => array (
        'defaults' => array(
            'email' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_ENABLED,
        )
    ),

    // New course created.
    'course_created'    => array (
        'defaults' => array(
            'email' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_ENABLED,
        )
    ),

    // A message for new enrolments in a course.
    'user_enrolment_created'    => array (
        'defaults' => array(
            'email' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_ENABLED,
        )
    ),

    // A message for course completions.
    'course_completed'    => array (
        'defaults' => array(
            'email' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_ENABLED,
        )
    ),
);
