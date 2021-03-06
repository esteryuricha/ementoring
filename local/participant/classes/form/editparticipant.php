<?php
namespace local_participant\form;
use moodleform;

require_once("$CFG->libdir/formslib.php");

class editparticipant extends moodleform {
    public function definition() {
        global $CFG;

        $mform = $this->_form;

        $mform->addElement('html', '<div class="content-container">');

        //active
        $mform->addElement('checkbox',  'visible',  'Active');
        $mform->setDefault('visible', 1);

        //first name
        $mform->addElement('text', 'firstname', 'First Name');
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

        //handphone
        $mform->addElement('text', 'phone1', 'Handphone');
        $mform->setType('phone1', PARAM_NOTAGS);
        $mform->addRule('phone1', null, 'required');

        //password
        $mform->addElement('passwordunmask', 'password', get_string('newpassword'), 'size="20"' . $purpose);
        $mform->addHelpButton('password', 'password');
        $mform->disabledIf('password', 'createpassword', 'checked');

        //photo
        $mform->addElement('hidden', 'picture', 'Photo', null, array('maxbytes' => 0, 'accepted_types' => '*'));
        
        //button
        $this->add_action_buttons();
    }

    function validation($data, $files) {
        return array();
    }
}

?>