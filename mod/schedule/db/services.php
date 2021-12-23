<?php
$functions = array(
    'mod_schedule_get_schedules' => array(         //web service function name
        'classname'   => 'mod_schedule_external',  //class containing the external function OR namespaced class in classes/external/XXXX.php
        'methodname'  => 'get_schedules',          //external function name
        'classpath'   => 'mod/schedule/externallib.php',  //file containing the class/external function - not required if using namespaced auto-loading classes.
        'description' => 'Gets schedules',    //human readable description of the web service function
        'type'        => 'write',                  //database rights of the web service function (read, write)
        'ajax' => true,        // is the service available to 'internal' ajax calls.
        'capabilities' => '', // comma separated list of capabilities used by the function.
    ),
    'mod_schedule_save_schedule' => array(         //web service function name
        'classname'   => 'mod_schedule_external',  //class containing the external function OR namespaced class in classes/external/XXXX.php
        'methodname'  => 'save_schedule',          //external function name
        'classpath'   => 'mod/schedule/externallib.php',  //file containing the class/external function - not required if using namespaced auto-loading classes.
        'description' => 'Save a schedule',    //human readable description of the web service function
        'type'        => 'write',                  //database rights of the web service function (read, write)
        'ajax' => true,        // is the service available to 'internal' ajax calls.
        'capabilities' => '', // comma separated list of capabilities used by the function.
    ),
    'mod_schedule_checkin' => array(         //web service function name
        'classname'   => 'mod_schedule_external',  //class containing the external function OR namespaced class in classes/external/XXXX.php
        'methodname'  => 'checkin',          //external function name
        'classpath'   => 'mod/schedule/externallib.php',  //file containing the class/external function - not required if using namespaced auto-loading classes.
        'description' => 'Check in to one schedule of the event',    //human readable description of the web service function
        'type'        => 'write',                  //database rights of the web service function (read, write)
        'ajax' => true,        // is the service available to 'internal' ajax calls.
        'capabilities' => '', // comma separated list of capabilities used by the function.
    ),
    'mod_schedule_view_detail' => array(         //web service function name
        'classname'   => 'mod_schedule_external',  //class containing the external function OR namespaced class in classes/external/XXXX.php
        'methodname'  => 'view_detail',          //external function name
        'classpath'   => 'mod/schedule/externallib.php',  //file containing the class/external function - not required if using namespaced auto-loading classes.
        'description' => 'View detail of participants check in',    //human readable description of the web service function
        'type'        => 'write',                  //database rights of the web service function (read, write)
        'ajax' => true,        // is the service available to 'internal' ajax calls.
        'capabilities' => '', // comma separated list of capabilities used by the function.
    ),
);
?>