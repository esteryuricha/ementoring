<?php
use local_schedule\manager;

require_once(__DIR__.'/../../config.php');

//get param
$id = optional_param('id', null, PARAM_INT);

global $DB;

$title = "Schedule Management";
$PAGE->set_url(new moodle_url('/local/schedule/index.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title($title);
$PAGE->requires->js('/local/schedule/assets/main.js');

echo $OUTPUT->header();

$manager = new manager();
$schedules = $manager->get_schedules($id);

$templatecontext = (object)[
    'schedules' => array_values($schedules),
    'addUrl' => new moodle_url($CFG->wwwroot.'/local/schedule/editschedule.php?id='.$id),
];

echo $OUTPUT->render_from_template('local_schedule/table', $templatecontext);

echo $OUTPUT->footer();
?>