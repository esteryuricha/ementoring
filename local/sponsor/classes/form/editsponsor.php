<?php
namespace local_sponsor\form;
use moodleform;

require_once("$CFG->libdir/formslib.php");

class editsponsor extends moodleform {
    public function definition() {
        global $CFG;

        $mform = $this->_form;

        $mform->addElement('html', '<div class="content-container">');

        //active
        $mform->addElement('checkbox',  'visible',  get_string('active','local_sponsor'));
        $mform->setDefault('visible', 1);

        //first name
        $mform->addElement('text', 'firstname', get_string('first_name','local_sponsor'));
        $mform->setType('firstname', PARAM_NOTAGS);
        $mform->addRule('firstname', null, 'required');
        
        //lastname
        $mform->addElement('text', 'lastname', get_string('last_name','local_sponsor'));
        $mform->setType('lastname', PARAM_NOTAGS);
        $mform->addRule('lastname', null, 'required');

        //email
        $mform->addElement('text', 'email', get_string('email','local_sponsor'), ['id' => 'email']);
        $mform->setType('email', PARAM_NOTAGS);
        $mform->addRule('email', null, 'required');

        $mform->addElement('html', '<div id="email_check"></div>');

        //password
        $mform->addElement('passwordunmask', 'password', get_string('new_password','local_sponsor'), 'size="20"' . $purpose);
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