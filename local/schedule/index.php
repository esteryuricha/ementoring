<?php
use local_schedule\manager;

require_once(__DIR__.'/../../config.php');
require_login();

//get param
$id = optional_param('id', null, PARAM_INT);

global $DB, $SESSION;

$SESSION->currentcourseid = $id;

$title = get_string('header', 'local_schedule');
$PAGE->set_url(new moodle_url('/local/schedule/index.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_pagelayout('course');
$PAGE->set_pagetype('course-view-schedule');
$PAGE->blocks->add_region('content');


$PAGE->requires->js('/local/schedule/assets/main.js');

echo $OUTPUT->header();

$manager = new manager();
$schedules = $manager->get_schedules($id);

$templatecontext = (object)[
    'schedules' => array_values($schedules),
    'addUrl' => new moodle_url($CFG->wwwroot.'/local/schedule/editschedule.php?id='.$id),
];

echo $OUTPUT->custom_block_region('content');
echo $OUTPUT->render_from_template('local_schedule/table', $templatecontext);

echo $OUTPUT->footer();
?>