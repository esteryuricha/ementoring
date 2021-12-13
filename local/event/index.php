<?php
use local_event\manager;

require_once(__DIR__.'/../../config.php');

global $DB;

$title = "Program Management";
$PAGE->set_url(new moodle_url('/local/event/index.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_pagelayout('course');
$PAGE->set_pagetype('my-index');
$PAGE->blocks->add_region('content');


$PAGE->requires->js_call_amd('local_event/confirm');

echo $OUTPUT->header();

$manager = new manager();
$categories = $manager->get_events();

$templatecontext = (object)[
    'categories' => array_values($categories),
    'addUrl' => new moodle_url($CFG->wwwroot.'/local/event/editevent.php'),
];

echo $OUTPUT->render_from_template('local_event/table', $templatecontext);
echo $OUTPUT->custom_block_region('content');

echo $OUTPUT->footer();
?>