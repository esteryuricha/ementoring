<?php
namespace local_event\form;
use moodleform;

require_once("$CFG->libdir/formslib.php");

class editevent extends moodleform {
    public function definition() {
        global $CFG;

        $mform = $this->_form;

        $mform->addElement('html', '<div class="content-container">');

        //active
        $mform->addElement('checkbox',  'visible',  get_string('active', 'local_event'));
        $mform->setDefault('visible', 1);

        //category ID
        $mform->addElement('text', 'idnumber', get_string('program_id', 'local_event'));
        $mform->setType('idnumber', PARAM_NOTAGS);

        //category name
        $mform->addElement('text', 'name', get_string('program_name', 'local_event'));
        $mform->setType('name', PARAM_NOTAGS);
        $mform->addRule('name', null, 'required');

        //start date
        $mform->addElement('date_time_selector', 'startdate', get_string('start_date', 'local_event'));
        $mform->addRule('startdate', null, 'required');

        //end date 
        $mform->addElement('date_time_selector', 'enddate', get_string('end_date', 'local_event'));
        $mform->addRule('enddate', null, 'required');
        
        //button
        $this->add_action_buttons();
    }

    function validation($data, $files) {
        return array();
    }
}

?>