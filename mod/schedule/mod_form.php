<?php
if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once($CFG->dirroot.'/mod/schedule/lib.php');

class mod_schedule_mod_form extends moodleform_mod {

    function definition() {
        global $CFG, $DB, $OUTPUT;

        $mform =& $this->_form;

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

        $this->standard_coursemodule_elements();

        $this->add_action_buttons();
    }
}