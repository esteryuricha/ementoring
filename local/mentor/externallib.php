<?php
defined('MOODLE_INTERNAL') || die();

use local_mentor\manager;
require_once($CFG->libdir . "/externallib.php");

class local_mentor_external extends external_api  {
    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function delete_mentor_parameters() {
        return new external_function_parameters(
            ['id' => new external_value(PARAM_INT, 'id of mentor')],
        );
    }

    /**
     * The function itself
     * @return string welcome mentor
     */
    public static function delete_mentor($id): string {
        $params = self::validate_parameters(self::delete_mentor_parameters(), array('id'=>$id));

        $manager = new manager();
        return $manager->delete_mentor($id);
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function delete_mentor_returns() {
        return new external_value(PARAM_BOOL, 'True if the mentor was successfully deleted.');
    }

    //check an email

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function check_email_parameters() {
        return new external_function_parameters(
            ['email' => new external_value(PARAM_TEXT, 'email of participant')],
        );
    }

    /**
     * The function itself
     * @return string welcome participant
     */
    public static function check_email($email): string {
        $params = self::validate_parameters(self::check_email_parameters(), array('email'=>$email));

        $manager = new manager();
        return $manager->check_email($email);
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function check_email_returns() {
        return new external_value(PARAM_RAW, 'checked email');
    }

}
?>
