<?php
defined('MOODLE_INTERNAL') || die();

use local_event\manager;
require_once($CFG->libdir . "/externallib.php");

class local_event_external extends external_api  {
    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function delete_event_parameters() {
        return new external_function_parameters(
            ['id' => new external_value(PARAM_INT, 'id of event')]
        );
    }

    /**
     * The function itself
     * @return string welcome event
     */
    public static function delete_event($id): string {
        $params = self::validate_parameters(self::delete_event_parameters(), array('id'=>$id));

        $manager = new manager();
        return $manager->delete_event($id);
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function delete_event_returns() {
        return new external_value(PARAM_BOOL, 'True if the event was successfully deleted.');
    }
}
?>
