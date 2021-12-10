<?php
namespace local_schedule\form;
use moodleform;

require_once("$CFG->libdir/formslib.php");

class editschedule extends moodleform {
    public function definition() {
        global $CFG, $DB;

        $mform = $this->_form;

        //eventid
        $selectArray = array();
        $events = $DB->get_records_sql("SELECT id, name FROM {event} where eventtype='category'"); //must get the current event

        $selectArray[0] = "choose event type";
        foreach( $events as $event ) {
            $key = $event->id;
            $value = $event->name;
            $selectArray[$key] = $value;
        }

        $mform->addElement('select', 'eventid', 'Event Type', $selectArray, ['id' => 'eventid']);

        //selecteddate
        $mform->addElement('text', 'selecteddate', 'Date', ['id' => 'selecteddate']);

        //selectedtime
        $mform->addElement('date_time_selector', 'selectedtime', 'Time', ['startyear' => 2021]);
        
        //button
        $this->add_action_buttons();
    }

    function validation($data, $files) {
        return array();
    }
}

?>