<?php
namespace local_class\form;
use moodleform;

require_once("$CFG->libdir/formslib.php");

class editclass extends moodleform {
    public function definition() {
        global $CFG, $DB, $SESSION;

        $mform = $this->_form;

        $mform->addElement('html', '<div class="content-container">');

        //active
        $mform->addElement('checkbox',  'visible',  get_string('active', 'local_class'));
        $mform->setDefault('visible', 1);

        //category id
        $selectArray = array();
        $categories = $DB->get_records('course_categories');

        foreach( $categories as $category ) {
            $key = $category->id;
            $value = $category->name;
            $selectArray[$key] = $value;
        }

        $mform->addElement('select', 'category', get_string('program', 'local_class'), $selectArray);
        $mform->setDefault('category', $SESSION->selectedcategory);
        $mform->addRule('category', null, 'required');

        //category ID
        $mform->addElement('text', 'idnumber', get_string('course_id', 'local_class'));
        $mform->setType('idnumber', PARAM_NOTAGS);

        //category name
        $mform->addElement('text', 'fullname', get_string('course_name', 'local_class'));
        $mform->setType('fullname', PARAM_NOTAGS);
        $mform->addRule('fullname', null, 'required');

        //button
        $this->add_action_buttons();
    }

    function validation($data, $files) {
        return array();
    }
}

?>