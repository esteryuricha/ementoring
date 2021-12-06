<?php
namespace local_class\form;
use moodleform;

require_once("$CFG->libdir/formslib.php");

class editclass extends moodleform {
    public function definition() {
        global $CFG, $DB;

        $mform = $this->_form;

        //active
        $mform->addElement('checkbox',  'visible',  'Active');
        $mform->setDefault('visible', 1);

        //category id
        $selectArray = array();
        $categories = $DB->get_records('course_categories');

        foreach( $categories as $category ) {
            $key = $category->id;
            $value = $category->name;
            $selectArray[$key] = $value;
        }

        $mform->addElement('select', 'category', 'Program', $selectArray);

        //category ID
        $mform->addElement('text', 'idnumber', 'Class ID');
        $mform->setType('idnumber', PARAM_NOTAGS);

        //category name
        $mform->addElement('text', 'fullname', 'Class Name');
        $mform->setType('fullname', PARAM_NOTAGS);

        //mentor 
        $selectMentors = array();
        $mentors = $DB->get_records_sql("select u.id, u.firstname, u.lastname from {user} u inner join {role_assignments} ra on u.id = ra.userid where ra.roleid = 3 order by firstname, lastname asc");

        foreach($mentors as $mentor) {
            $key = $mentor->id;
            $value = $mentor->firstname." ".$mentor->lastname;
            $selectMentors[$key] = $value;
        }

        $mform->addElement('select', 'user', 'Mentor', $selectMentors);
        
        //button
        $this->add_action_buttons();
    }

    function validation($data, $files) {
        return array();
    }
}

?>