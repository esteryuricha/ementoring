<?php
$functions = array(
    'local_participant_delete_participant' => array(         //web service function name
        'classname'   => 'local_participant_external',  //class containing the external function OR namespaced class in classes/external/XXXX.php
        'methodname'  => 'delete_participant',          //external function name
        'classpath'   => 'local/participant/externallib.php',  //file containing the class/external function - not required if using namespaced auto-loading classes.
        'description' => 'Deletes a participant',    //human readable description of the web service function
        'type'        => 'write',                  //database rights of the web service function (read, write)
        'ajax' => true,        // is the service available to 'internal' ajax calls.
        'capabilities' => '', // comma separated list of capabilities used by the function.
    ),
);
