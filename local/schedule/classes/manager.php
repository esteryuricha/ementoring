<?php
namespace local_schedule;

use dml_exception;
use stdClass;

class manager {
    function getdates($id) {
        global $DB;


        $event = $DB->get_record_sql("SELECT timestart, timeduration FROM {event} WHERE id=$id");
        
        return $event->timestart;
    }
}