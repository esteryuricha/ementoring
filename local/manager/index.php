<?php
use local_manager\manager;

require_once(__DIR__.'/../../config.php');
require_login();

global $DB;

$title = "Manager Management";
$PAGE->set_url(new moodle_url('/local/manager/index.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_pagelayout('mydashboard');
$PAGE->set_pagetype('my-index');
$PAGE->blocks->add_region('content');

$PAGE->requires->js_call_amd('local_manager/confirm');

echo $OUTPUT->header();

$manager = new manager();
$managers = $manager->get_managers();

$templatecontext = (object)[
    'managers' => array_values($managers),
    'addUrl' => new moodle_url($CFG->wwwroot.'/local/manager/editmanager.php'),
];

echo $OUTPUT->render_from_template('local_manager/table', $templatecontext);
echo $OUTPUT->custom_block_region('content');

echo $OUTPUT->footer();
?>