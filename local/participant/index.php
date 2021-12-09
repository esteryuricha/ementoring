<?php
use local_participant\manager;

require_once(__DIR__.'/../../config.php');

global $DB;

$title = "Participant Management";
$PAGE->set_url(new moodle_url('/local/participant/index.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title($title);
$PAGE->set_heading($title);

$PAGE->requires->js_call_amd('local_participant/confirm');

echo $OUTPUT->header();

$manager = new manager();
$participants = $manager->get_participants();

$templatecontext = (object)[
    'participants' => array_values($participants),
    'addUrl' => new moodle_url($CFG->wwwroot.'/local/participant/editparticipant.php'),
    'importUrl' => new moodle_url($CFG->wwwroot.'/admin/tool/uploaduser/index.php')
];

echo $OUTPUT->render_from_template('local_participant/table', $templatecontext);

echo $OUTPUT->footer();
?>