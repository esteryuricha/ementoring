<?php
use local_manager\form\editmanager;
use local_manager\manager;

require_once(__DIR__.'/../../config.php');

require_login();

global $DB, $SESSION;

$title = "Add New Manager";
$PAGE->set_url(new moodle_url('/local/manager/editmanager.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_pagelayout('course');
$PAGE->set_pagetype('my-index');
$PAGE->blocks->add_region('content');
$PAGE->requires->js('/local/manager/assets/form.js');



//breadcrumb
$previewnode = $PAGE->navigation->add('Manager Management', new moodle_url('/local/manager/index.php'), navigation_node::TYPE_CONTAINER);
$thingnode = $previewnode->add($title, new moodle_url('/local/manager/editmanager.php'));
$thingnode->make_active();

//get param
$id = optional_param('id', null, PARAM_INT);

//form here
$mform = new editmanager();

if ($mform->is_cancelled()) {
    
    redirect($CFG->wwwroot.'/local/manager/index.php');

} else if ($fromform = $mform->get_data()) {

    $manager = new manager();

    if($SESSION->current_id) { 
        $manager->update_manager($fromform->visible ?? 0, $fromform->firstname, $fromform->lastname, $fromform->email, $fromform->password, $fromform->picture ?? null);
    }else{
        $manager->insert_manager($fromform->visible ?? 0, $fromform->firstname, $fromform->lastname, $fromform->email, $fromform->password, $fromform->picture ?? null);    
    }

    redirect($CFG->wwwroot.'/local/manager/index.php', 'success');

}

if($id) {
    $sql = "SELECT (1 ^ suspended) AS visible,
            firstname, lastname, email, picture
            FROM {user}
            WHERE id=$id";
    $manager = $DB->get_record_sql($sql);
        
    $mform->set_data($manager);

    $SESSION->current_id = $id;
}

echo $OUTPUT->header();

$mform->display();
echo $OUTPUT->custom_block_region('content');


echo $OUTPUT->footer();

?>