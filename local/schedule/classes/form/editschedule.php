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
        $events = $DB->get_records('event'); //must get the current event

        foreach( $events as $event ) {
            $key = $event->id;
            $value = $event->name;
            $selectArray[$key] = $value;
        }

        $mform->addElement('select', 'eventid', 'Event Type', $selectArray);

        //selecteddate
        
        
        //button
        $this->add_action_buttons();
    }

    function validation($data, $files) {
        return array();
    }
}

?>