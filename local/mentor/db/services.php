<?php
$functions = array(
    'local_mentor_delete_mentor' => array(         //web service function name
        'classname'   => 'local_mentor_external',  //class containing the external function OR namespaced class in classes/external/XXXX.php
        'methodname'  => 'delete_mentor',          //external function name
        'classpath'   => 'local/mentor/externallib.php',  //file containing the class/external function - not required if using namespaced auto-loading classes.
        'description' => 'Deletes a mentor',    //human readable description of the web service function
        'type'        => 'write',                  //database rights of the web service function (read, write)
        'ajax' => true,        // is the service available to 'internal' ajax calls.
        'capabilities' => '', // comma separated list of capabilities used by the function.
    ),
    'local_mentor_check_email' => array(         //web service function name
        'classname'   => 'local_mentor_external',  //class containing the external function OR namespaced class in classes/external/XXXX.php
        'methodname'  => 'check_email',          //external function name
        'classpath'   => 'local/mentor/externallib.php',  //file containing the class/external function - not required if using namespaced auto-loading classes.
        'description' => 'Checks an Email',    //human readable description of the web service function
        'type'        => 'write',                  //database rights of the web service function (read, write)
        'ajax' => true,        // is the service available to 'internal' ajax calls.
        'capabilities' => '', // comma separated list of capabilities used by the function.
    ),
);
