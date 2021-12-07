<?php
namespace local_event;

use dml_exception;
use stdClass;

class manager {

    /** Insert the data into our database table.
     * @param string $idnumber
     * @param string $name
     * @param date $startdate
     * @param date $enddate
     * @param int $visible
     * @return bool true if successful
     */

    public function insert_event(array $data, array $datafordate):bool {
        global $DB;

        try {
            \core_course_category::create($data);

            //get last category id 
            $categoryid = $DB->get_record_sql('SELECT id FROM {course_categories} ORDER BY id DESC LIMIT 1')->id;
            
            $addtolocalevent = new stdClass();
            $addtolocalevent->category = $categoryid;
            $addtolocalevent->startdate = $datafordate['startdate'];
            $addtolocalevent->enddate = $datafordate['enddate'];
        
            return $DB->insert_record('local_event', $addtolocalevent, false);
        } catch(dml_exception $e) {
            return false;
        }
    }

    function get_events(): array
    {
        global $DB;
        $sql = "SELECT ROW_NUMBER() OVER(order by cc.id desc) AS num, 
                    cc.visible, 
                    cc.id, 
                    cc.idnumber, 
                    cc.name, 
                    le.startdate, 
                    le.enddate, 
                    (select count(c.id) from {course} c where c.category = cc.id) as course_count 
                FROM {course_categories} cc 
                LEFT JOIN {local_event} le 
                ON cc.id = le.category";
        return $DB->get_records_sql($sql);
    }

    function update_event(int $visible, string $idnumber, string $name, int $startdate, int $enddate): bool {
        global $DB, $SESSION;

        $id = $SESSION->current_id;

        $recordtoupdate = new stdClass();
        $recordtoupdate->name = $name;
        $recordtoupdate->idnumber = $idnumber;
        $recordtoupdate->visible = $visible;
        $recordtoupdate->visibleold = $visible;
        $recordtoupdate->id = $id;

        $DB->update_record('course_categories', $recordtoupdate);

        $updatelocalevent->startdate = $startdate;
        $updatelocalevent->enddate = $enddate;
        $updatelocalevent->category = $id;

        $DB->execute('update {local_event} set startdate='.$startdate.', enddate='.$enddate.' where category='.$SESSION->current_id, null);
        
        $SESSION->current_id = "";

        return true;
    }

    function delete_event($id) {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $deletedDetail = $DB->delete_records('local_event', ['category' => $id]);
        $deletedEvent = $DB->delete_records('course_categories', ['id' => $id]);

        if($deletedEvent && $deletedDetail) {
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }
}