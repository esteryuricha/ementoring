<?php
require_once(__DIR__.'/../../config.php');
require_login();

$title = "Statistics";
$PAGE->set_url(new moodle_url('/local/statistic/index.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title($title);
$PAGE->set_heading($title);
$PAGE->set_pagelayout('course');
$PAGE->set_pagetype('my-index');
$PAGE->blocks->add_region('content');

global $DB;

$programs = $DB->get_records_sql('SELECT idnumber as name, (SELECT COUNT(*) FROM {course} c WHERE category = cc.id) as course_count  FROM {course_categories} cc');

//get programs for label and course count
$listprogram = array();
$coursecount = array();
foreach($programs as $program){
    array_push($listprogram, $program->name);
    array_push($coursecount, $program->course_count);
}

//get data for chart2
$sql = "SELECT cc.idnumber as name, 
            (SELECT count(ue.userid) as mentor 
            FROM {user_enrolments} ue 
            INNER JOIN {enrol} e 
                ON ue.enrolid = e.id 
            INNER JOIN {role_assignments} ra 
                ON ue.userid = ra.userid 
            INNER JOIN {course} c 
                ON c.id = e.courseid 
            WHERE c.category = cc.id 
                AND ra.roleid=3 
            GROUP BY c.category) 
        AS mentorcount, 
            (SELECT count(ue.userid) as mentor 
            FROM {user_enrolments} ue 
            INNER JOIN {enrol} e 
                ON ue.enrolid = e.id 
            INNER JOIN {role_assignments} ra 
                ON ue.userid = ra.userid 
            INNER JOIN {course} c 
                ON c.id = e.courseid 
            WHERE c.category = cc.id 
                AND ra.roleid=5 
            GROUP BY c.category) 
        AS participantcount  
        FROM {course_categories} cc";
$userbyprograms = $DB->get_records_sql($sql);

$listcategory = array();
$listmentor = array();
$listparticipant = array();
foreach( $userbyprograms as $p){
    array_push($listcategory, $p->name);
    array_push($listmentor, $p->mentorcount);
    array_push($listparticipant, $p->participantcount);   
}

$chart = new core\chart_bar();
$chart->set_title('Class Amount By Program');
$series = new core\chart_series('class', $coursecount);
$chart->add_series($series);
$chart->set_labels($listprogram);

$chart1 = new \core\chart_bar(); // Create a bar chart instance.
$chart1->set_title('User Amount');
$participants = new \core\chart_series('participant', $listparticipant);
$mentors = new \core\chart_series('mentor', $listmentor);
$chart1->add_series($participants);
$chart1->add_series($mentors);
$chart1->set_labels($listcategory);


echo $OUTPUT->header();
echo $OUTPUT->render($chart);
echo "<br><br>";
echo $OUTPUT->render($chart1);
echo $OUTPUT->footer();
