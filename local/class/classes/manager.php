<?php
namespace local_class;

use dml_exception;
use stdClass;

class manager {
    public function insert_class(int $visible, int $category, string $idnumber, string $fullname): bool {
        global $DB;

        //get program start date and end date
        $course_category = $DB->get_record_sql("SELECT startdate, enddate from {local_event} where id = '$category'");

        $recordtoinsert = new stdClass();
        $recordtoinsert->visible = $visible;
        $recordtoinsert->fullname = $fullname;
        $recordtoinsert->idnumber = $idnumber;
        $recordtoinsert->category = $category;
        $recordtoinsert->shortname = $fullname;
        $recordtoinsert->startdate = $course_category->startdate;
        $recordtoinsert->enddate = $course_category->enddate;
        $recordtoinsert->showactivitydates = 1;
        $recordtoinsert->showcompletionconditions = 1;
        $recordtoinsert->enablecompletion = 1;
    
        try {
            $courseid = $DB->insert_record('course', $recordtoinsert);

            //add to mdl_enrol
            $inserttoenrol->enrol = "manual";
            $inserttoenrol->courseid = $courseid;
            $inserttoenrol->sororder = 1;
            $inserttoenrol->roleid = 5;

            $enrolid = $DB->insert_record('enrol', $inserttoenrol);

            //create introduction section
            $inserttosection->course = $courseid;
            $inserttosection->section = 0;
            $inserttosection->name = "Introduction";
            $inserttosection->summary = '<p dir="ltr" style="text-align: left;">Welcome to class '.$shortname.'</p>';

            $DB->insert_record('course_sections', $inserttosection, false);

            //topic section 
            $inserttotopicsection->course = $courseid;
            $inserttotopicsection->section = 1;
            $inserttotopicsection->name = "Topic 1";

            return $DB->insert_record('course_sections', $inserttotopicsection, false);

        } catch(dml_exception $e) {
            return false;
        }
    }

    function get_classes(): array
    {
        global $DB, $SESSION, $USER;

        //get role
        $role_assignment = $DB->get_record_sql("SELECT r.id 
                                                FROM {role} r 
                                                INNER JOIN {role_assignments} ra 
                                                    ON r.id = ra.roleid 
                                                WHERE ra.userid='$USER->id' LIMIT 1");

        //add menu class for mentor and participant
        if($role_assignment->id == 3 || $role_assignment->id == 5) {
            $sql = "SELECT ROW_NUMBER() OVER(order by c.id DESC) AS num,
                    c.id,
                    c.visible,
                    cc.name AS program_name, 
                    c.fullname, 
                    c.idnumber
                    FROM {course_categories} cc 
                    INNER JOIN {course} c 
                        ON cc.id = c.category 
                    INNER JOIN {enrol} e 
                        ON e.courseid = c.id 
                    INNER JOIN {user_enrolments} ue 
                        ON ue.enrolid = e.id 
                    WHERE ue.userid = '$USER->id' 
                        AND cc.id = '$SESSION->selectedcategory'
                    ORDER BY cc.id DESC";
        }else{
            $sql = "SELECT ROW_NUMBER() OVER(order by c.id desc) AS num,
                    c.id,
                    c.visible,
                    cc.name AS program_name, 
                    c.fullname, 
                    c.idnumber 
                    FROM {course} c 
                    JOIN {course_categories} cc 
                        ON c.category = cc.id
                    WHERE cc.id = '$SESSION->selectedcategory'
                    ORDER BY cc.id DESC"; 
        }

        return $DB->get_records_sql($sql);
    }

    function update_class(int $visible, int $category, string $idnumber, string $fullname, int $user): bool {
        global $DB, $SESSION;

        $id = $SESSION->current_id;

        //get program start date and end date
        $course_category = $DB->get_record_sql("SELECT startdate, enddate from {course_categories} where id = '$category'");

        $recordtoupdate = new stdClass();
        $recordtoupdate->visible = $visible;
        $recordtoupdate->fullname = $fullname;
        $recordtoupdate->idnumber = $idnumber;
        $recordtoupdate->category = $category;
        $recordtoupdate->shortname = $fullname;
        $recordtoupdate->startdate = $course_category->startdate;
        $recordtoupdate->enddate = $course_category->enddate;
        $recordtoupdate->id = $id;

        $DB->update_record('course', $recordtoupdate);

        $enrolid = $DB->get_record_sql("select id from {enrol} where courseid=$id")->id;

        $DB->execute('update {user_enrolments} set userid='.$user.' where enrolid='.$enrolid, null);
        
        $SESSION->current_id = "";

        return true;
    }

    function delete_class($id) {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $course = $DB->get_record_sql('select e.id as enrolid, ue.id as userenrolid from {course} c inner join {enrol} e on c.id = e.courseid inner join {user_enrolments} ue on e.id = ue.enrolid where c.id = '.$id);
        $deletedUserEnrol = $DB->delete_records('user_enrolments', ['id' => $course->userenrolid]);
        $deletedEnrol = $DB->delete_records('enrol', ['id' => $course->enrolid]);
        $deletedCourse = $DB->delete_records('course', ['id' => $id]);

        if($deletedCourse) {
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }

    function setcategory($id)
    {
        global $SESSION;

        $SESSION->selectedcategory = $id;

        return true;
    }
}