<?php
defined('MOODLE_INTERNAL') || die();

use local_manager\manager;
require_once($CFG->libdir . "/externallib.php");

class local_manager_external extends external_api  {
    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function delete_manager_parameters() {
        return new external_function_parameters(
            ['id' => new external_value(PARAM_INT, 'id of manager')],
        );
    }

    /**
     * The function itself
     * @return string welcome manager
     */
    public static function delete_manager($id): string {
        $params = self::validate_parameters(self::delete_manager_parameters(), array('id'=>$id));

        $manager = new manager();
        return $manager->delete_manager($id);
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function delete_manager_returns() {
        return new external_value(PARAM_BOOL, 'True if the manager was successfully deleted.');
    }
}
?>
