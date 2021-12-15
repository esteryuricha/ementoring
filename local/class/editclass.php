<?php
use local_class\form\editclass;
use local_class\manager;

require_once(__DIR__.'/../../config.php');

require_login();

global $DB, $SESSION;

$title = "Add New Class";
$PAGE->set_url(new moodle_url('/local/class/editclass.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_pagelayout('course');
$PAGE->set_pagetype('my-index');
$PAGE->blocks->add_region('content');
    

//breadcrumb
$previewnode = $PAGE->navigation->add('Program Management', new moodle_url('/local/class/index.php'), navigation_node::TYPE_CONTAINER);
$thingnode = $previewnode->add($title, new moodle_url('/local/class/editclass.php'));
$thingnode->make_active();

//get param
$id = optional_param('id', null, PARAM_INT);

//form here
$mform = new editclass();

if ($mform->is_cancelled()) {
    
    redirect($CFG->wwwroot.'/local/class/index.php');

} else if ($fromform = $mform->get_data()) {

    $manager = new manager();

    if($SESSION->current_id) { 
        $manager->update_class($fromform->visible ?? 0, $fromform->category, $fromform->idnumber, $fromform->fullname, $fromform->user);
    }else{
        $manager->insert_class($fromform->visible ?? 0, $fromform->category, $fromform->idnumber, $fromform->fullname, $fromform->user);    
    }

    redirect($CFG->wwwroot.'/local/class/index.php', 'success');

}

if($id) {
    $sql = "SELECT c.visible, 
            c.fullname, c.idnumber, c.category 
            FROM {course} c
            INNER JOIN {enrol} e
                ON c.id = e.courseid
            INNER JOIN {user_enrolments} ue
                ON ue.enrolid = e.id
            WHERE c.id = $id";
    $course = $DB->get_record_sql($sql);
        
    $mform->set_data($course);

    $SESSION->current_id = $id;
}

echo $OUTPUT->header();

$mform->display();
echo $OUTPUT->custom_block_region('content');

echo $OUTPUT->footer();

?>