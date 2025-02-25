<?php

/**
 * @package    local
 * @subpackage engagement_email
 * @copyright  2025 Josemaria Bolanos <admin@mako.digital>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('NO_OUTPUT_BUFFERING', true);

require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');

$action  = required_param('action', PARAM_ALPHANUMEXT);
$confirm = optional_param('confirm', 0, PARAM_BOOL);

$return = new moodle_url('/user/profile.php');

$context = context_system::instance();

$PAGE->set_url('/local/engagement_email/unsubscribe.php');
$PAGE->set_context($context);

if (!$confirm) {
    $optionsyes = array('confirm' => 1, 'sesskey' => sesskey(), 'action' => $action);

    echo $OUTPUT->header();
    $formcontinue = new single_button(new moodle_url('/local/engagement_email/unsubscribe.php', $optionsyes), get_string('yes'));
    $formcancel = new single_button($return, get_string('no'), 'get');
    echo $OUTPUT->confirm(get_string('confirm:' . $action, 'local_engagement_email'), $formcontinue, $formcancel);
    echo $OUTPUT->footer();

    die();
}

// Editing own message profile.
require_capability('moodle/user:editownmessageprofile', $context);

if (\local_engagement_email\message::toggle_notifications($action)) {
    \core\notification::add(get_string($action, 'local_engagement_email'), \core\notification::SUCCESS);
} else {
    \core\notification::add(get_string('error:' . $action, 'local_engagement_email'), \core\notification::ERROR);
}

redirect($return);
