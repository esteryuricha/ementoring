<?php
namespace mod_schedule;

use dml_exception;
use stdClass;

class manager {
    function get_schedules($eventid){
        global $DB, $SESSION;

        $schedules = $DB->get_records('local_schedule', ['eventid' => $eventid, 'courseid' => $SESSION->currentcourseid]);
        
        $list = "";
        $ids = array();
        foreach($schedules as $schedule){
            // $list .= "<button type='button' class='btn btn-primary choose_schedule_button' value='{{$schedule->id}}'>Select</button> ".date('d M Y', $schedule->selecteddate)." ".$schedule->selectedtime."<br><br>";
            $list .= "<input type='radio' name='$eventid' id='choose$schedule->id' value='$schedule->id'> ".date('d M Y', $schedule->selecteddate)." ".$schedule->selectedtime."<br><br>";
            array_push($ids, $schedule->id);
        }

        return json_encode($ids)."|".$list;
    }

    function save_schedule($id){
        global $DB, $SESSION, $USER;

        $group = $DB->get_record_sql("SELECT g.id FROM {groups} g JOIN {groups_members} gm ON g.id = gm.groupid WHERE gm.userid = $USER->id and g.courseid = $SESSION->currentcourseid");

        $recordtoupdate = new stdClass();
        $recordtoupdate->groupid = $group->id;
        $recordtoupdate->id = $id;

        $DB->update_record('local_schedule', $recordtoupdate);

        return true;

    }

    function checkin($scheduleid) {
        global $DB, $USER, $SESSION;
                
        $recordtoinsert = new stdClass();
        $recordtoinsert->scheduleid = $scheduleid;
        $recordtoinsert->participantid = $USER->id;
        $recordtoinsert->participantcheck = 1;
        $recordtoinsert->participantcheckedtime = strtotime(date('Y-m-d H:i:s'));
        
        return $DB->insert_record('local_schedule_detail', $recordtoinsert, true);        
    }
}
?>