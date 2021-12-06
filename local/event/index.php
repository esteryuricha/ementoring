<?php
use local_event\manager;

require_once(__DIR__.'/../../config.php');

global $DB;

$title = "Program Management";
$PAGE->set_url(new moodle_url('/local/event/index.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title($title);
$PAGE->set_heading($title);

$PAGE->requires->js_call_amd('local_event/confirm');

echo $OUTPUT->header();

$manager = new manager();
$categories = $manager->get_events();

$templatecontext = (object)[
    'categories' => array_values($categories),
    'addUrl' => new moodle_url($CFG->wwwroot.'/local/event/editevent.php'),
];

echo $OUTPUT->render_from_template('local_event/table', $templatecontext);

echo $OUTPUT->footer();
?>