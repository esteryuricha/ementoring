<?php
defined('MOODLE_INTERNAL') || die();

use mod_schedule\manager;
require_once($CFG->libdir . "/externallib.php");

class mod_schedule_external extends external_api  {

    //get_schedules functions
    public static function get_schedules_parameters() {
        return new external_function_parameters(
            ['id' => new external_value(PARAM_INT, 'id of event')],
        );
    }

    public static function get_schedules($id): string {
        $params = self::validate_parameters(self::get_schedules_parameters(), array('id'=>$id));

        $manager = new manager();
        return $manager->get_schedules($id);
    }

    public static function get_schedules_returns() {
        return new external_value(PARAM_RAW, 'test');
    }

    //save schedule
    public static function save_schedule_parameters() {
        return new external_function_parameters(
            ['id' => new external_value(PARAM_INT, 'id of event')],
        );
    }

    public static function save_schedule($id): string {
        $params = self::validate_parameters(self::save_schedule_parameters(), array('id'=>$id));

        $manager = new manager();
        return $manager->save_schedule($id);
    }

    public static function save_schedule_returns() {
        return new external_value(PARAM_RAW, 'test');
    }

    //checkin
    public static function checkin_parameters() {
        return new external_function_parameters(
            ['eventid' => new external_value(PARAM_INT, 'id of event')],
        );
    }

    public static function checkin($id): string {
        $params = self::validate_parameters(self::checkin_parameters(), array('eventid'=>$id));

        $manager = new manager();
        return $manager->checkin($id);
    }

    public static function checkin_returns() {
        return new external_value(PARAM_RAW, 'test');
    }

    //view detail on mentor page functions
    public static function view_detail_parameters() {
        return new external_function_parameters(
            ['id' => new external_value(PARAM_INT, 'id of schedule')],
        );
    }

    public static function view_detail($id): string {
        $params = self::validate_parameters(self::view_detail_parameters(), array('id'=>$id));

        $manager = new manager();
        return $manager->view_detail($id);
    }

    public static function view_detail_returns() {
        return new external_value(PARAM_RAW, 'test');
    }


}
?>
