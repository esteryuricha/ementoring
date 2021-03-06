<?php
namespace local_schedule\form;
use moodleform;

require_once("$CFG->libdir/formslib.php");

class editschedule extends moodleform {
    public function definition() {
        global $CFG, $DB, $SESSION;

        $mform = $this->_form;

        $course = $DB->get_record('course', ['id' => $SESSION->currentcourseid]);

        //eventid
        $selectArray = array();
        $events = $DB->get_records_sql("SELECT id, name FROM {event} where eventtype='category' and categoryid='$course->category'"); //must get the current event

        $selectArray[0] = get_string('choose_event_type', 'local_schedule');
        foreach( $events as $event ) {
            $key = $event->id;
            $value = $event->name;
            $selectArray[$key] = $value;
        }

        $mform->addElement('select', 'eventid', get_string('event_type', 'local_schedule'), $selectArray, ['id' => 'eventid']);
        $mform->addRule('eventid', null, 'required');

        //selecteddate
        $mform->addElement('select', 'availabledates', get_string('selected_date', 'local_schedule'), [], ['id' => 'availabledates']);
        $mform->addElement('hidden', 'selecteddate', '', ['id' => 'selecteddate']);
        $mform->setType('selecteddate', PARAM_NOTAGS);
        $mform->addRule('availabledates', null, 'required');

        //selectedtime
        $selectTime = [
            '06:00:00' => '06:00',
            '06:30:00' => '06:30',
            '07:00:00' => '07:00',
            '07:30:00' => '07:30',
            '08:00:00' => '08:00',
            '08:30:00' => '08:30',
            '09:00:00' => '09:00',
            '09:30:00' => '09:30',
            '10:00:00' => '10:00',
            '10:30:00' => '10:30',
            '11:00:00' => '11:00',
            '11:30:00' => '11:30',
            '12:00:00' => '12:00',
            '12:30:00' => '12:30',
            '13:00:00' => '13:00',
            '13:30:00' => '13:30',
            '14:00:00' => '14:00',
            '14:30:00' => '14:30',
            '15:00:00' => '15:00',
            '15:30:00' => '15:30',
            '16:00:00' => '16:00',
            '16:30:00' => '16:30',
            '17:00:00' => '17:00',
            '17:30:00' => '17:30',
            '18:00:00' => '18:00',
            '18:30:00' => '18:30',
            '19:00:00' => '19:00',
            '19:30:00' => '19:30',
            '20:00:00' => '20:00',
            '20:30:00' => '20:30',
            '21:00:00' => '21:00',
            '21:30:00' => '21:30',
            '22:00:00' => '22:00',
            '22:30:00' => '22:30'
        ];

        //selectedtime
        $mform->addElement('select', 'selectedtime', get_string('selected_time', 'local_schedule'), $selectTime);
        $mform->addRule('selectedtime', null, 'required');

        //button
        $this->add_action_buttons();
    }

    function validation($data, $files) {
        return array();
    }
}

?>