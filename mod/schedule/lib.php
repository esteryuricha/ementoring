<?php
defined('MOODLE_INTERNAL') || die();

function schedule_add_instance(stdclass $schedule) {
    global $DB;

    //get event name 
    $event = $DB->get_record('event', ['id' => $schedule->eventid]);

    $recordtoinsert = new stdClass();
    $recordtoinsert->eventid = $schedule->eventid;
    $recordtoinsert->course = $schedule->course;
    $recordtoinsert->name = $event->name;

    $returnid = $DB->insert_record('schedule', $recordtoinsert);
    $instance = $DB->get_record('schedule', array('id'=>$returnid), '*', MUST_EXIST);

    $course = $DB->get_record('course', array('id'=>$schedule->course), '*', MUST_EXIST);

    return $returnid;

}

function schedule_update_instance(stdclass $schedule) {
    return true;
}

function schedule_delete_instance($id) {
    return true;
}

function mod_schedule_cm_info_view(cm_info $cm) {
    
}
?>