<?php
namespace local_mentor\form;
use moodleform;

require_once("$CFG->libdir/formslib.php");

class editmentor extends moodleform {
    public function definition() {
        global $CFG;

        $mform = $this->_form;

        $mform->addElement('html', '<div class="content-container">');

        //active
        $mform->addElement('checkbox',  'visible',  'Active');
        $mform->setDefault('visible', 1);
        
        //first name
        $mform->addElement('text', 'firstname', 'First Name', array('class'=>'test'));
        $mform->setType('firstname', PARAM_NOTAGS);
        $mform->addRule('firstname', null, 'required');
        
        //lastname
        $mform->addElement('text', 'lastname', 'Last Name');
        $mform->setType('lastname', PARAM_NOTAGS);
        $mform->addRule('lastname', null, 'required');

        //email
        $mform->addElement('text', 'email', 'Email', ['id' => 'email']);
        $mform->setType('email', PARAM_NOTAGS);
        $mform->addRule('email', null, 'required');

        $mform->addElement('html', '<div id="email_check"></div>');

        //password
        $mform->addElement('passwordunmask', 'password', get_string('newpassword'), 'size="20"' . $purpose);
        $mform->addHelpButton('password', 'password');
        $mform->disabledIf('password', 'createpassword', 'checked');

        //picture
        $mform->addElement('hidden', 'picture', 'Photo', null, array('accepted_types' => array('jpg', 'png'), 'maxfiles' => 1, 'maxbytes' => $CFG->maxbytes, 'subdirs' => 0));
        
        //button
        $this->add_action_buttons();
    }

    function validation($data, $files) {
        return array();
    }
}

?>