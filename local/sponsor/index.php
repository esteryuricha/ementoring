<?php
use local_sponsor\manager;

require_once(__DIR__.'/../../config.php');
require_login();
require_capability('local/sponsor:addinstance', context_system::instance());

global $DB;

$title = "Sponsor Management";
$PAGE->set_url(new moodle_url('/local/sponsor/index.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_pagelayout('course');
$PAGE->set_pagetype('my-index');
$PAGE->blocks->add_region('content');
$PAGE->requires->js('/local/sponsor/assets/main.js');

echo $OUTPUT->header();

$sponsor = new manager();
$sponsors = $sponsor->get_sponsors();

$templatecontext = (object)[
    'sponsors' => array_values($sponsors),
    'addUrl' => new moodle_url($CFG->wwwroot.'/local/sponsor/editsponsor.php'),
];

echo $OUTPUT->render_from_template('local_sponsor/table', $templatecontext);
echo $OUTPUT->custom_block_region('content');

echo $OUTPUT->footer();
?>