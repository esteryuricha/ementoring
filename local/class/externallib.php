<?php
defined('MOODLE_INTERNAL') || die();

use local_class\manager;
require_once($CFG->libdir . "/externallib.php");

class local_class_external extends external_api  {
    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function delete_class_parameters() {
        return new external_function_parameters(
            ['id' => new external_value(PARAM_INT, 'id of class')],
        );
    }

    /**
     * The function itself
     * @return string welcome class
     */
    public static function delete_class($id): string {
        $params = self::validate_parameters(self::delete_class_parameters(), array('id'=>$id));

        $manager = new manager();
        return $manager->delete_class($id);
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function delete_class_returns() {
        return new external_value(PARAM_BOOL, 'True if the class was successfully deleted.');
    }
}
?>
