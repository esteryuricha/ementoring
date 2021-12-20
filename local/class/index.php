<?php
use local_class\manager;

require_once(__DIR__.'/../../config.php');

global $DB, $USER;

$title = "Class Management";
$PAGE->set_url(new moodle_url('/local/class/index.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_pagelayout('course');
$PAGE->set_pagetype('my-index');
$PAGE->blocks->add_region('content');

$PAGE->requires->js('/local/class/assets/main.js');

echo $OUTPUT->header();

$manager = new manager();
$classes = $manager->get_classes();

//get role
$role_assignment = $DB->get_record_sql("select r.id from {role} r inner join {role_assignments} ra on r.id = ra.roleid where ra.userid=$USER->id");
$view_mentor = true;
//add menu class for mentor and participant
if($role_assignment->id == 3 || $role_assignment->id == 5) {
    $view_mentor = false;

    $sql = "SELECT cc.id, cc.name 
                FROM {course_categories} cc 
                INNER JOIN {course} c 
                    ON cc.id = c.category 
                INNER JOIN {enrol} e 
                    ON e.courseid = c.id 
                INNER JOIN {user_enrolments} ue 
                    ON ue.enrolid = e.id 
                WHERE ue.userid = $USER->id 
                GROUP BY cc.idnumber
                ORDER BY cc.id DESC";
    
    $categories = $DB->get_records_sql($sql);
}


$templatecontext = (object)[
    'classes' => array_values($classes),
    'addUrl' => new moodle_url($CFG->wwwroot.'/local/class/editclass.php'),
    'viewUrl' => new moodle_url($CFG->wwwroot.'/course/view.php'),
    'viewMentor' => $view_mentor,
    'categories' => array_values($categories)
];

echo $OUTPUT->render_from_template('local_class/table', $templatecontext);
echo $OUTPUT->custom_block_region('content');

echo $OUTPUT->footer();
?>