<?php
namespace local_participant;

use dml_exception;
use stdClass;

class manager {

    /** Insert the data into our database table.
     */

    public function insert_participant(int $suspended, string $firstname, string $lastname, string $email, string $password, string $picture): bool {
        global $DB;

        //condition must be reverse, because in user table there's only suspended column
        $suspended = $suspended==0 ? 1 : 0;

        $recordtoinsert = new stdClass();
        $recordtoinsert->suspended = $suspended;
        $recordtoinsert->firstname = $firstname;
        $recordtoinsert->lastname = $lastname;
        $recordtoinsert->username = $email;
        $recordtoinsert->email = $email;
        $recordtoinsert->password = hash_internal_user_password($password);
        $recordtoinsert->confirmed = 1;
        $recordtoinsert->mnethostid = 1;
    
        try {
            $userid = $DB->insert_record('user', $recordtoinsert);
        
            //add to role assignments
            $recordtoroleassignments->userid = $userid;
            $recordtoroleassignments->contextid = 1;
            $recordtoroleassignments->roleid = 5;
            
            return $DB->insert_record('role_assignments', $recordtoroleassignments, false);
        } catch(dml_exception $e) {
            return false;
        }
    }

    function get_participants(): array
    {
        global $DB;
        $sql = "SELECT ROW_NUMBER() OVER(order by u.id) AS num,
                u.id,
                suspended,
                u.firstname, 
                u.lastname, 
                u.username, 
                u.email
                FROM {user} u 
                INNER JOIN {role_assignments} ra 
                ON u.id = ra.userid 
                WHERE ra.roleid=5 and contextid=1";
        return $DB->get_records_sql($sql);
    }

    function update_participant(int $suspended, string $firstname, string $lastname, string $email, string $password, string $picture): bool {
        global $DB, $SESSION;

        $id = $SESSION->current_id;

        //condition must be reverse, because in user table there's only suspended column
        $suspended = $suspended==0 ? 1 : 0;

        $recordtoupdate = new stdClass();
        $recordtoupdate->suspended = $suspended;
        $recordtoupdate->firstname = $firstname;
        $recordtoupdate->lastname = $lastname;
        $recordtoupdate->username = $email;
        $recordtoupdate->email = $email;
        $recordtoupdate->id = $id;

        if($password)
            $recordtoupdate->password = hash_internal_user_password($password);

        $DB->update_record('user', $recordtoupdate);
        
        $SESSION->current_id = "";

        return true;
    }

    function delete_participant($id) {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $deletedRoleAssigment = $DB->delete_records('role_assignments', ['userid' => $id]);
        $deleted = $DB->delete_records('user', ['id' => $id]);

        if($deleted) {
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }
}