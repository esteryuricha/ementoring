<?php
$functions = array(
    'local_monitoring_getgroups' => array(         //web service function name
        'classname'   => 'local_monitoring_external',  //class containing the external function OR namespaced class in classes/external/XXXX.php
        'methodname'  => 'getgroups',          //external function name
        'classpath'   => 'local/monitoring/externallib.php',  //file containing the class/external function - not required if using namespaced auto-loading classes.
        'description' => 'Gets groups',    //human readable description of the web service function
        'type'        => 'write',                  //database rights of the web service function (read, write)
        'ajax' => true,        // is the service available to 'internal' ajax calls.
        'capabilities' => '', // comma separated list of capabilities used by the function.
    ),
    'local_monitoring_getschedules' => array(         //web service function name
        'classname'   => 'local_monitoring_external',  //class containing the external function OR namespaced class in classes/external/XXXX.php
        'methodname'  => 'getschedules',          //external function name
        'classpath'   => 'local/monitoring/externallib.php',  //file containing the class/external function - not required if using namespaced auto-loading classes.
        'description' => 'Gets groups schedules by event',    //human readable description of the web service function
        'type'        => 'write',                  //database rights of the web service function (read, write)
        'ajax' => true,        // is the service available to 'internal' ajax calls.
        'capabilities' => '', // comma separated list of capabilities used by the function.
    ),
);
