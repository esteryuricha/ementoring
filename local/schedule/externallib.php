<?php
defined('MOODLE_INTERNAL') || die();

use local_schedule\manager;
require_once($CFG->libdir . "/externallib.php");

class local_schedule_external extends external_api  {
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
        new external_value('timestart', PARAM_INT, 'timestart');
    }
}
?>
