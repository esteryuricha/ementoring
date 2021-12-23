<?php
require('../../config.php');
require_once('lib.php');
require_once($CFG->libdir.'/completionlib.php');


$id = required_param('id', PARAM_INT);
list ($course, $cm) = get_course_and_cm_from_cmid($id, 'schedule');
$schedule = $DB->get_record('schedule', array('id'=> $cm->instance), '*', MUST_EXIST);
$course = $DB->get_record('course', array('id'=>$cm->course), '*', MUST_EXIST);

global $SESSION;

$SESSION->currentcourseid = $cm->course;

require_login($course, true, $cm);
$context = context_module::instance($cm->id);


$title = "Schedule for ".$schedule->name;
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_url('/mod/schedule/view.php', array('id' => $cm->id));
$PAGE->requires->js('/mod/schedule/assets/modal.js');


echo $OUTPUT->header();

//get role
$role_assignment = $DB->get_record_sql("select r.id from {role} r inner join {role_assignments} ra on r.id = ra.roleid where ra.userid=$USER->id");

//if mentor
if( $role_assignment->id != 5 ){
    //get all team data
    $groups = $DB->get_records_sql("SELECT 
                                        id, 
                                        name,
                                        (SELECT CONCAT(FROM_UNIXTIME(selecteddate,'%d %M %Y'),' ', selectedtime) FROM {local_schedule} ls WHERE groupid = g.id AND eventid = $schedule->eventid) as chosendata
                                    FROM {groups} g 
                                    WHERE courseid = $cm->course");

    $templatecontext = (object)[
        'backUrl' => new moodle_url($CFG->wwwroot.'/course/view.php?id='.$cm->course),
        'scheduleName' => $schedule->name,
        'eventid' => $schedule->eventid,
        'groups' => array_values($groups)
    ];

    echo $OUTPUT->render_from_template('mod_schedule/listschedule', $templatecontext);

}else if( $role_assignment->id == 5 ){
    //get group id
    $group = $DB->get_record_sql("SELECT g.id, g.name FROM {groups} g JOIN {groups_members} gm ON g.id = gm.groupid WHERE gm.userid = $USER->id and g.courseid = $cm->course");
    $groupid = $group->id;

    //check first
    $checklocalschedule = $DB->get_record('local_schedule', ['eventid' => $schedule->eventid, 'groupid' => $groupid, 'courseid' => $cm->course]);
    $allowedtocheckin = false;

    if($checklocalschedule) {
        $scheduledate = date('Y-m-d', $checklocalschedule->selecteddate);
        
        if($scheduledate == date('Y-m-d')){
            $allowedtocheckin = true;
        }

        $checkinstatus = $DB->get_record('local_schedule_detail', ['scheduleid' => $checklocalschedule->id, 'participantid' => $USER->id]);
        
        if($checkinstatus->participantcheck) {
            $checkintime = date('d M Y H:i:s', $checkinstatus->participantcheckedtime);
        }
        
        if($checkinstatus->mentorcheck) {
            $checkintime = date('d M Y H:i:s', $checkinstatus->mentorcheckedtime);
        }
    }

    $templatecontext = (object)[
        'backUrl' => new moodle_url($CFG->wwwroot.'/course/view.php?id='.$cm->course),
        'addUrl' => new moodle_url($CFG->wwwroot.'/local/event/editevent.php'),
        'scheduleName' => $schedule->name,
        'checklocalschedule' => $checklocalschedule,
        'eventid' => $schedule->eventid,
        'allowedtocheckin' => $allowedtocheckin,
        'checkintime' => $checkintime
    ];

    echo $OUTPUT->render_from_template('mod_schedule/viewschedule', $templatecontext);
}



echo $OUTPUT->footer();


