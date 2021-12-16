<?php
namespace mod_schedule\form;
use moodleform;

require_once("$CFG->libdir/formslib.php");

class chooseschedule extends moodleform {
    public function definition() {
        global $CFG;

        $mform = $this->_form;

        //available schedule
        $selectArray = array();
        $schedules = $DB->get_records_sql("SELECT id, selecteddate, selectedtime FROM {local_schedule} WHERE eventid=''");

        foreach( $schedules as $schedule ) {
            $key = $schedule->id;
            $value = $schedule->selecteddate." ".$schedule->selectedtime;
            $selectArray[$key] = $value;
        }

        $mform->addElement('select', 'scheduleid', 'Choose Schedule', $selectArray, ['id' => 'scheduleid']);

    }
}