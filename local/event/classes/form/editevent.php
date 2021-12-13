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
        $mform->addElement('checkbox',  'visible',  'Active');
        $mform->setDefault('visible', 1);

        //category ID
        $mform->addElement('text', 'idnumber', 'Program ID');
        $mform->setType('idnumber', PARAM_NOTAGS);

        //category name
        $mform->addElement('text', 'name', 'Program Name');
        $mform->setType('name', PARAM_NOTAGS);

        //start date
        $mform->addElement('date_time_selector', 'startdate', 'Start Date');

        //end date 
        $mform->addElement('date_time_selector', 'enddate', 'End Date');
        
        //button
        $this->add_action_buttons();
    }

    function validation($data, $files) {
        return array();
    }
}

?>