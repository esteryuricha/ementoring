<?php
use local_event\form\editevent;
use local_event\manager;

require_once(__DIR__.'/../../config.php');

require_login();

global $DB, $SESSION;

$title = "Add New Program";
$PAGE->set_url(new moodle_url('/local/event/editevent.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title($title);
$PAGE->set_heading($title);

//breadcrumb
$previewnode = $PAGE->navigation->add('Program Management', new moodle_url('/local/event/index.php'), navigation_node::TYPE_CONTAINER);
$thingnode = $previewnode->add($title, new moodle_url('/local/event/editevent.php'));
$thingnode->make_active();

//get param
$id = optional_param('id', null, PARAM_INT);

//form here
$mform = new editevent();

if ($mform->is_cancelled()) {
    
    redirect($CFG->wwwroot.'/local/event/index.php');

} else if ($fromform = $mform->get_data()) {

    $manager = new manager();

    if($SESSION->current_id) { 
        $manager->update_event($fromform->visible ?? 0, $fromform->idnumber, $fromform->name, $fromform->startdate, $fromform->enddate);
    }else{
        $manager->insert_event($fromform->visible ?? 0, $fromform->idnumber, $fromform->name, $fromform->startdate, $fromform->enddate);    
    }

    redirect($CFG->wwwroot.'/local/event/index.php', 'success');

}

if($id) {
    $sql = "SELECT visible, idnumber, name, startdate, enddate FROM {course_categories} cc left join {local_event} le on cc.id = le.category where cc.id=$id";
    $category = $DB->get_record_sql($sql);
        
    $mform->set_data($category);

    $SESSION->current_id = $id;
}

echo $OUTPUT->header();

$mform->display();

echo $OUTPUT->footer();

?>