<?php
namespace local_monitoring;

use dml_exception;
use stdClass;

class manager {
    function getgroups($id) {
        global $DB;

        $course = $DB->get_record('course', ['id' => $id]);

        $sql = "SELECT id, name, description
                FROM {groups} WHERE courseid = '$id'";
        $groups = $DB->get_records_sql($sql);
        
        $data = "<h3>Detail Groups of <b>$course->fullname</b></h3>";
        $data .= "<table class='table table-bordered border-primary'>";
        $data .= "<thead>";
        $data .= "<tr>
                    <th scope='col'>Group</th>
                    <th scope='col'>Description</th>
                    <th scope='col'>Member</th>
                    <th scope='col'>Class Completion</th>
                  </tr></thead>";
        $data .= "<tbody>";

        $content = "";
        foreach($groups as $group) {
            $content .= "<tr>";
            $content .= "<td>".$group->name."</td>";  
            $content .= "<td>".$group->description."</td>";

            //get members
            $members = $DB->get_records_sql("SELECT u.id, u.firstname, 
                                            u.lastname, u.email 
                                            FROM {user} u 
                                            INNER JOIN {groups_members} gm 
                                            ON u.id = gm.userid 
                                            WHERE gm.groupid = '$group->id'");
            
            
            if($members) {
                $content .= "<td>";
                $filter_users = "";
                $idx = 1;
                foreach($members as $member) {
                    $content .= $member->firstname." ".$member->lastname." (".$member->email.")<br>";
                    $filter_users .= "userid = ".$member->id;
                    
                    if($idx != count($members)) {
                        $filter_users .= " or ";
                    }
                    $idx++;
                }
                $content .= "</td>";
            }else{
                $content .= "<td></td>";
                $filter_users = "cm.id!= null";
            }

            //get completion
            $module = $DB->get_record_sql("SELECT count(*) as modulecount 
                                            FROM {course_modules} 
                                            WHERE course=$id");
            $completion = $DB->get_record_sql("SELECT count(completionstate) as completioncount 
                                                FROM {course_modules_completion} cmc 
                                                INNER JOIN {course_modules} cm 
                                                    ON cmc.coursemoduleid = cm.id
                                                WHERE cm.course= $id AND ($filter_users) 
                                                GROUP BY cmc.coursemoduleid");
            if($module && $members){
                if($completion->completioncount) {
                    $progress = $completion->completioncount/$module->modulecount*100;
                }else{
                    $progress = 0;
                }
            }else{
                $progress = 0;
            }
            $content .= "<td>".$progress."%</td>";

            $content .= "</tr>";
        }

        $data .= $content;
        $data .= "</tbody>";
        $data .= "</table>";

        return $data;
    }

    function getschedules($id) {
        global $DB;

        $course = $DB->get_record('course', ['id' => $id]);

        $data = "<h3>Detail Schedules of <b>$course->fullname</b></h3>";

        $events = $DB->get_records_sql("SELECT * FROM {event} WHERE categoryid='$course->category' ORDER BY id DESC");
    
        if($events){
            $data .= "<table class='table table-bordered border-primary'>";
            foreach($events as $event) {
                $startime = date('d M Y', $event->timestart);
                $endtime = date('d M Y', ((int)$event->timestart + (int)$event->timeduration));
                $duration = $startime. " until ".$endtime;
                $data .= "<tr>
                            <th colspan='2' scope='col'>".$event->name." (".$duration.")</th>
                        </tr>";

                // $mentorschedules = $DB->get_records_sql("SELECT selecteddate, selectedtime 
                //                                             FROM {local_schedule} ls
                //                                             WHERE eventid='$event->id' AND courseid='$id'
                //                                             ORDER BY selecteddate ASC");

                $mentorschedules = $DB->get_records('local_schedule', ['eventid' => $event->id, 'courseid' => $id]);

                if(count($mentorschedules) > 0) {   
                    $data .= "<tr>
                                <th scope='col'>Mentor's Schedules</th>
                                <th scope='col'>Group</th>
                            </tr>";

                    foreach($mentorschedules as $mentorschedule) {
                        $group = $DB->get_record('groups', ['id' => $mentorschedule->groupid]);
                        $data .= "<tr>
                                    <td>".date('d M Y', $mentorschedule->selecteddate)." ".$mentorschedule->selectedtime."</td>
                                    <td>$group->name</td>
                                    </tr>";
                    }

                    //get unassigned team
                    $unassignedteams = $DB->get_records_sql("SELECT g.name 
                                                                FROM {groups} g 
                                                                WHERE NOT EXISTS (SELECT * FROM {local_schedule} ls 
                                                                WHERE ls.groupid = g.id AND ls.eventid='$event->id') AND courseid='$id'");

                    if($unassignedteams) {
                        $data .= "<tr>
                                    <td>Unassigned Team(s) :</td>";
                        $data .= "<td>";
                        foreach($unassignedteams as $ua) {
                            $data .= $ua->name."<br>";
                        }
                        $data .= "</td>";
                    }
                }else{
                    $data .= "<tr><td colspan='2'>No Assigned Schedule Yet</td></tr>";
                }
                
                $data .= "<tr><td colspan='2'></td></tr>";
            }

            return $data;
        }else{
            return "No events yet";
        }
    }
}