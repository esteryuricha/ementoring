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

    function view_detail($scheduleid) {
        global $DB;

        $schedule = $DB->get_record('local_schedule', ['id' => $scheduleid]);

        $details = $DB->get_records_sql("SELECT u.id, u.firstname, u.lastname, u.email
                                        FROM {user} u
                                        INNER JOIN {groups_members} gm
                                            ON u.id = gm.userid
                                        WHERE gm.groupid = $schedule->groupid");

        $data = "<table class='generaltable'>";
        $data .= "<tr>
                    <th scope='col'>Member</th>
                    <th scope='col'>Status</th>
                </tr>";
        foreach($details as $detail) {
            $checkin = $DB->get_record('local_schedule_detail', ['scheduleid' => $scheduleid, 'participantid' => $detail->id]);

            if($checkin) {
                if($checkin->participantcheck){
                    $checkintime = date('d M Y H:i:s', $checkin->participantcheckedtime);
                }

                if($checkin->mentorcheck) {
                    $checkintime = date('d M Y H:i:s', $checkin->mentorcheckedtime);
                }
            }else{
                $checkintime = "not checked-in yet. check-in now";
            }

            $data .= "<tr>";
            $data .= "<td>".$detail->firstname." ".$detail->lastname."(".$detail->email.")</td>
                        <td>".$checkintime."</td>";

            $data .= "</tr>";
        }
        $data .= "</table>";

        return $data;
    }
}
?>