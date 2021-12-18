<?php
use local_monitoring\manager;
defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . "/externallib.php");

class local_monitoring_external extends external_api  {

    //getgroups functions

    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function getgroups_parameters() {
        return new external_function_parameters(
            ['id' => new external_value(PARAM_INT, 'id of course')],
        );
    }

    /**
     * The function itself
     * @return string welcome monitoring
     */
    public static function getgroups($id): string {
        $params = self::validate_parameters(self::getgroups_parameters(), array('id'=>$id));

        $manager = new manager();
        return $manager->getgroups($id);
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function getgroups_returns() {
        return new external_value(PARAM_RAW, 'groups');
    }


    //get schedules
    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function getschedules_parameters() {
        return new external_function_parameters(
            ['id' => new external_value(PARAM_INT, 'id of course')],
        );
    }

    /**
     * The function itself
     * @return string welcome monitoring
     */
    public static function getschedules($id): string {
        $params = self::validate_parameters(self::getgroups_parameters(), array('id'=>$id));

        $manager = new manager();
        return $manager->getschedules($id);
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function getschedules_returns() {
        return new external_value(PARAM_RAW, 'schedules');
    }


}
?>
