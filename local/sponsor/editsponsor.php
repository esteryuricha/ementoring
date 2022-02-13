<?php
use local_sponsor\form\editsponsor;
use local_sponsor\manager;

require_once(__DIR__.'/../../config.php');

require_login();

global $DB, $SESSION;

$title = get_string('add_new_sponsor', 'local_sponsor');
$PAGE->set_url(new moodle_url('/local/sponsor/editsponsor.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_pagelayout('course');
$PAGE->set_pagetype('my-index');
$PAGE->blocks->add_region('content');
$PAGE->requires->js('/local/sponsor/assets/form.js');


//breadcrumb
$previewnode = $PAGE->navigation->add(get_string('header', 'local_sponsor'), new moodle_url('/local/sponsor/index.php'), navigation_node::TYPE_CONTAINER);
$thingnode = $previewnode->add($title, new moodle_url('/local/sponsor/editsponsor.php'));
$thingnode->make_active();

//get param
$id = optional_param('id', null, PARAM_INT);

//form here
$mform = new editsponsor();

if ($mform->is_cancelled()) {
    
    redirect($CFG->wwwroot.'/local/sponsor/index.php');

} else if ($fromform = $mform->get_data()) {

    $sponsor = new manager();

    if($SESSION->current_id) { 
        $sponsor->update_sponsor($fromform->visible ?? 0, $fromform->firstname, $fromform->lastname, $fromform->email, $fromform->password, $fromform->picture ?? null);
    }else{
        $sponsor->insert_sponsor($fromform->visible ?? 0, $fromform->firstname, $fromform->lastname, $fromform->email, $fromform->password, $fromform->picture ?? null);    
    }

    redirect($CFG->wwwroot.'/local/sponsor/index.php', 'success');

}

if($id) {
    $sql = "SELECT (1 ^ suspended) AS visible,
            firstname, lastname, email, picture
            FROM {user}
            WHERE id=$id";
    $sponsor = $DB->get_record_sql($sql);
        
    $mform->set_data($sponsor);

    $SESSION->current_id = $id;
}

echo $OUTPUT->header();

$mform->display();
echo $OUTPUT->custom_block_region('content');


echo $OUTPUT->footer();

?>