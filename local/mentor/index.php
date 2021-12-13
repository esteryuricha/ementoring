<?php
use local_mentor\manager;

require_once(__DIR__.'/../../config.php');

require_login();

global $DB;

$title = "Mentor Management";
$PAGE->set_context(\context_system::instance());
$PAGE->set_url(new moodle_url('/local/mentor/index.php'));
$PAGE->set_title($title);
$PAGE->set_heading($title);

$PAGE->set_pagelayout('mydashboard');
$PAGE->set_pagetype('my-index');
$PAGE->blocks->add_region('content');


$PAGE->requires->js_call_amd('local_mentor/confirm');

echo $OUTPUT->header();

$manager = new manager();
$mentors = $manager->get_mentors();

$templatecontext = (object)[
    'mentors' => array_values($mentors),
    'addUrl' => new moodle_url($CFG->wwwroot.'/local/mentor/editmentor.php'),
];

echo $OUTPUT->render_from_template('local_mentor/table', $templatecontext);
echo $OUTPUT->custom_block_region('content');


echo $OUTPUT->footer();
?>