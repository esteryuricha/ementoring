<?php
use local_schedule\form\editschedule;
use local_schedule\manager;

require_once(__DIR__.'/../../config.php');

require_login();    

global $DB, $SESSION;

//get param
$id = optional_param('id', null, PARAM_INT);


$title = get_string('add_new_schedule', 'local_schedule');
$PAGE->set_url(new moodle_url('/local/class/editschedule.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_pagelayout('course');
$PAGE->set_pagetype('course-view-schedule');
$PAGE->blocks->add_region('content');
$PAGE->requires->js('/local/schedule/assets/main.js');

//form here
$mform = new editschedule();

if ($mform->is_cancelled()) {
    
    redirect($CFG->wwwroot.'/local/schedule/index.php?id='.$SESSION->current_id);

} else if ($fromform = $mform->get_data()) {
    $manager = new manager();

    $manager->insert_schedule((int)$fromform->eventid, (int)$fromform->selecteddate, $fromform->selectedtime, $SESSION->current_id ?? null);

    // if($SESSION->current_id) { 
    //     $manager->update_class($fromform->visible ?? 0, $fromform->category, $fromform->idnumber, $fromform->fullname, $fromform->user);
    // }else{
    //     $manager->insert_class($fromform->visible ?? 0, $fromform->category, $fromform->idnumber, $fromform->fullname, $fromform->user);    
    // }

    redirect($CFG->wwwroot.'/local/schedule/index.php?id='.$SESSION->current_id, 'success');

    $SESSION->current_id = "";

}

if($id)
    $SESSION->current_id = $id;

echo $OUTPUT->header();
echo $OUTPUT->custom_block_region('content');

echo "<div class='content-container'>";
$mform->display();
echo "</div>";

echo $OUTPUT->footer();

?>