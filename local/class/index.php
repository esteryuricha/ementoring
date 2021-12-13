<?php
use local_class\manager;

require_once(__DIR__.'/../../config.php');

global $DB;

$title = "Class Management";
$PAGE->set_url(new moodle_url('/local/class/index.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_pagelayout('mydashboard');
$PAGE->set_pagetype('my-index');
$PAGE->blocks->add_region('content');

$PAGE->requires->js_call_amd('local_class/confirm');

echo $OUTPUT->header();

$manager = new manager();
$classes = $manager->get_classes();

$templatecontext = (object)[
    'classes' => array_values($classes),
    'addUrl' => new moodle_url($CFG->wwwroot.'/local/class/editclass.php'),
    'viewUrl' => new moodle_url($CFG->wwwroot.'/course/view.php')
];

echo $OUTPUT->render_from_template('local_class/table', $templatecontext);
echo $OUTPUT->custom_block_region('content');

echo $OUTPUT->footer();
?>