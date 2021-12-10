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
        global $DB;

        $recordtoinsert = new stdClass();
        $recordtoinsert->eventid = $eventid;
        $recordtoinsert->selecteddate = $selecteddate;
        $recordtoinsert->selectedtime = $selectedtime;
        $recordtoinsert->courseid = $courseid;

        return $DB->insert_record('local_schedule', $recordtoinsert);
    }

    function get_schedules($courseid) {
        global $DB;

        $sql = "SELECT ROW_NUMBER() OVER(order by ls.id) AS num,
                    e.name 'eventname' 
                FROM {local_schedule} ls
                JOIN {event} e 
                ON ls.eventid = e.id
                WHERE ls.courseid='$courseid'";
        return $DB->get_records_sql($sql);
    }
}