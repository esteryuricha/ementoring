<?php
use local_participant\form\editparticipant;
use local_participant\manager;

require_once(__DIR__.'/../../config.php');

require_login();

global $DB, $SESSION;

$title = "Add New Participant";
$PAGE->set_url(new moodle_url('/local/participant/editparticipant.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_pagelayout('course');
$PAGE->set_pagetype('my-index');
$PAGE->blocks->add_region('content');
$PAGE->requires->js('/local/participant/assets/form.js');


//breadcrumb
$previewnode = $PAGE->navigation->add('Participant Management', new moodle_url('/local/participant/index.php'), navigation_node::TYPE_CONTAINER);
$thingnode = $previewnode->add($title, new moodle_url('/local/participant/editparticipant.php'));
$thingnode->make_active();

//get param
$id = optional_param('id', null, PARAM_INT);

//form here
$mform = new editparticipant();

if ($mform->is_cancelled()) {
    
    redirect($CFG->wwwroot.'/local/participant/index.php');

} else if ($fromform = $mform->get_data()) {

    $manager = new manager();

    if($SESSION->current_id) { 
        $manager->update_participant($fromform->visible ?? 0, $fromform->firstname, $fromform->lastname, $fromform->email, $fromform->password, $fromform->picture ?? null, $fromform->phone1);
    }else{
        $manager->insert_participant($fromform->visible ?? 0, $fromform->firstname, $fromform->lastname, $fromform->email, $fromform->password, $fromform->picture ?? null, $fromform->phone1);    
    }

    redirect($CFG->wwwroot.'/local/participant/index.php', 'success');

}

if($id) {
    $sql = "SELECT (1 ^ suspended) AS visible,
            firstname, lastname, email, phone1
            FROM {user}
            WHERE id=$id";
    $participant = $DB->get_record_sql($sql);
        
    $mform->set_data($participant);

    $SESSION->current_id = $id;
}

echo $OUTPUT->header();

$mform->display();
echo $OUTPUT->custom_block_region('content');


echo $OUTPUT->footer();

?>