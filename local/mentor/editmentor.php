<?php
use local_mentor\form\editmentor;
use local_mentor\manager;

require_once(__DIR__.'/../../config.php');

require_login();

global $DB, $SESSION, $CFG;

$title = get_string('add_new_mentor', 'local_mentor');
$PAGE->set_url(new moodle_url('/local/mentor/editmentor.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title($title);
$PAGE->set_heading($title);

$PAGE->set_pagelayout('course');
$PAGE->set_pagetype('my-index');
$PAGE->blocks->add_region('content');
$PAGE->requires->js('/local/mentor/assets/main.js');


//breadcrumb
$previewnode = $PAGE->navigation->add('Mentor Management', new moodle_url('/local/mentor/index.php'), navigation_node::TYPE_CONTAINER);
$thingnode = $previewnode->add($title, new moodle_url('/local/mentor/editmentor.php'));
$thingnode->make_active();

//get param
$id = optional_param('id', null, PARAM_INT);

//form here
$mform = new editmentor();

if ($mform->is_cancelled()) {
    
    redirect($CFG->wwwroot.'/local/mentor/index.php');

} else if ($fromform = $mform->get_data()) {

    $manager = new manager();

    $id = $SESSION->current_id;

    // $context = \context_user::instance($id);

    // $usernew = $DB->get_record('user', ['id' => $id]);

    if($id) { 
        $manager->update_mentor($fromform->visible ?? 0, $fromform->firstname, $fromform->lastname, $fromform->email, $fromform->password);        
    }else{
        $userid = $manager->insert_mentor($fromform->visible ?? 0, $fromform->firstname, $fromform->lastname, $fromform->email, $fromform->password);    
        $manager->insert_role_assignment($userid);
    }

    redirect($CFG->wwwroot.'/local/mentor/index.php', 'success');

}

if($id) {
    $sql = "SELECT (1 ^ suspended) AS visible,
            firstname, lastname, email, picture
            FROM {user}
            WHERE id=$id";
    $mentor = $DB->get_record_sql($sql);

    $datatodisplay = [
        'visible'   => $mentor->visible,
        'firstname' => $mentor->firstname,
        'lastname'  => $mentor->lastname,
        'email'     => $mentor->email,
        'picture'   => ''
    ];

    $mform->set_data($datatodisplay);

    $SESSION->current_id = $id;
}

echo $OUTPUT->header();

$mform->display();
echo $OUTPUT->custom_block_region('content');


echo $OUTPUT->footer();

?>