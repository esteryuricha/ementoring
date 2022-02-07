<?php
defined('MOODLE_INTERNAL') || die();

use local_sponsor\manager;
require_once($CFG->libdir . "/externallib.php");

class local_sponsor_external extends external_api  {
    /**
     * Returns description of method parameters
     * @return external_function_parameters
     */
    public static function delete_sponsor_parameters() {
        return new external_function_parameters(
            ['id' => new external_value(PARAM_INT, 'id of sponsor')],
        );
    }

    /**
     * The function itself
     * @return string welcome sponsor
     */
    public static function delete_sponsor($id): string {
        $params = self::validate_parameters(self::delete_sponsor_parameters(), array('id'=>$id));

        $sponsor = new manager();
        return $sponsor->delete_sponsor($id);
    }

    /**
     * Returns description of method result value
     * @return external_description
     */
    public static function delete_sponsor_returns() {
        return new external_value(PARAM_BOOL, 'True if the sponsor was successfully deleted.');
    }
}
?>
