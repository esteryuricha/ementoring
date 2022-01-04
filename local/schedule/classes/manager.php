<?php
namespace local_schedule;

use dml_exception;
use stdClass;

class manager {
    function getdates($id) {
        global $DB;

        $event = $DB->get_record_sql("SELECT timestart, timeduration FROM {event} WHERE id=$id");
        
        return json_encode($event);
    }

    function insert_schedule(int $eventid, int $selecteddate, string $selectedtime, int $courseid): bool {
        global $DB, $USER;

        $recordtoinsert = new stdClass();
        $recordtoinsert->courseid = $courseid;
        $recordtoinsert->eventid = $eventid;
        $recordtoinsert->selecteddate = $selecteddate;
        $recordtoinsert->selectedtime = $selectedtime;
        $recordtoinsert->userid = $USER->id;

        return $DB->insert_record('local_schedule', $recordtoinsert);
    }

    function get_schedules($courseid) {
        global $DB;

        $sql = "SELECT ROW_NUMBER() OVER(order by selecteddate ASC, selectedtime ASC) AS num,
                    ls.id,
                    e.name 'eventname',
                    ls.selecteddate,
                    ls.selectedtime,
                    g.name as enrolledteam,
                    u.firstname,
                    u.lastname
                FROM {local_schedule} ls
                JOIN {event} e 
                    ON ls.eventid = e.id
                LEFT JOIN {user} u
                    ON u.id = ls.userid
                LEFT JOIN {groups} g 
                    ON g.id = ls.groupid
                WHERE ls.courseid='$courseid'
                ORDER BY selecteddate ASC, selectedtime ASC";
        return $DB->get_records_sql($sql);
    }

    function delete_schedule($id) {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $deleteSchedule = $DB->delete_records('local_schedule', ['id' => $id]);

        if($deleteSchedule) {
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }
}