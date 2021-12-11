<?php
defined('MOODLE_INTERNAL') || die();

use local_schedule\manager;
require_once($CFG->libdir . "/externallib.php");

class local_schedule_external extends external_api  {

    //getdates functions

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function getdates_parameters() {
        return new external_function_parameters(
            ['id' => new external_value(PARAM_INT, 'id of event')],
        );
    }

    /**
     * The function itself
     * @return string welcome schedule
     */
    public static function getdates($id): string {
        $params = self::validate_parameters(self::getdates_parameters(), array('id'=>$id));

        $manager = new manager();
        return $manager->getdates($id);
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function getdates_returns() {
        return new external_value(PARAM_RAW, 'test');
    }

    //delete functions
        /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function delete_schedule_parameters() {
        return new external_function_parameters(
            ['id' => new external_value(PARAM_INT, 'id of schedule')],
        );
    }

    /**
     * The function itself
     * @return string welcome schedule
     */
    public static function delete_schedule($id): string {
        $params = self::validate_parameters(self::delete_schedule_parameters(), array('id'=>$id));

        $manager = new manager();
        return $manager->delete_schedule($id);
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function delete_schedule_returns() {
        return new external_value(PARAM_BOOL, 'True if the schedule was successfully deleted.');
    }

}
?>
