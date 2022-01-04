<?php
require_once(__DIR__.'/../../config.php');

global $DB;

$id = optional_param('id', null, PARAM_INT);

//get program 
$program = $DB->get_record('course_categories', ['id' => $id]);

$title = "Monitoring Program ".$program->idnumber;
$PAGE->set_url(new moodle_url('/local/monitoring/index.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_pagelayout('course');
$PAGE->set_pagetype('my-index');
$PAGE->blocks->add_region('content');
$PAGE->requires->js('/local/monitoring/assets/main.js');

echo $OUTPUT->header();

//get classes
$sql = "SELECT ROW_NUMBER() OVER(order by c.id desc) AS num,
                c.id, c.fullname, u.firstname, u.lastname,
                (SELECT count(*) FROM {course_modules} cm WHERE course = c.id) as cm_count 
        FROM {course} c
        WHERE c.category = '$id'";
$classes = $DB->get_records_sql($sql);

$templatecontext = (object)[
    'classes' => array_values($classes),
];
echo $OUTPUT->render_from_template('local_monitoring/detail', $templatecontext);

echo $OUTPUT->footer();

