<?php
namespace local_participant;

use dml_exception;
use stdClass;

class manager {

    /** Insert the data into our database table.
     */

    public function insert_participant(int $suspended, string $firstname, string $lastname, string $email, string $password, string $picture, string $phone1): bool {
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
        $recordtoinsert->phone1 = $phone1;
    
        try {
            $userid = $DB->insert_record('user', $recordtoinsert);
        
            //add to role assignments
            $recordtoroleassignments = new stdClass();
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

        // //store unstored data first
        // $sql1 = "SELECT u.id 
        // FROM {user} u
        // WHERE NOT EXISTS(SELECT userid FROM {role_assignments} ra WHERE userid = u.id) AND u.id!=1 AND u.id!=2";

        // $unstoreddata = $DB->get_records_sql($sql1);

        // foreach($unstoreddata as $data)
        // {
        //     $recordtoinsert = new stdClass();
        //     $recordtoinsert->userid = $data->id;
        //     $recordtoinsert->roleid = 5;
        //     $recordtoinsert->contextid = 1;
        //     $recordtoinsert->timemodified = time();

        //     $DB->insert_record('role_assignments', $recordtoinsert, false);
        // }
    
        $sql = "SELECT ROW_NUMBER() OVER(order by u.id) AS num,
                u.id,
                suspended,
                u.firstname, 
                u.lastname, 
                u.username, 
                u.email,
                u.phone1
                FROM {user} u 
                INNER JOIN {role_assignments} ra 
                ON u.id = ra.userid 
                WHERE ra.roleid=5 and contextid=1";
        return $DB->get_records_sql($sql);
    }

    function update_participant(int $suspended, string $firstname, string $lastname, string $email, string $password, string $picture, string $phone1): bool {
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
        $recordtoupdate->phone1 = $phone1;
        $recordtoupdate->id = $id;

        if($password)
            $recordtoupdate->password = hash_internal_user_password($password);

        $DB->update_record('user', $recordtoupdate);
        
        $SESSION->current_id = "";

        return true;
    }

    function delete_participant($id): bool {
        global $DB;
        $transaction = $DB->start_delegated_transaction();
        $deletedRoleAssigment = $DB->delete_records('role_assignments', ['userid' => $id]);
        $deleted = $DB->delete_records('user', ['id' => $id]);

        if($deleted) {
            $DB->commit_delegated_transaction($transaction);
        }

        return true;
    }

    function check_email($email) {
        global $DB;

        $sql = "SELECT email FROM {user} WHERE email = '$email' LIMIT 1";
        $available_email = $DB->get_records_sql($sql);

        if( $available_email ) {
            $return_value = "Not Allowed";
        }else{
            $return_value = "Allowed";
        }

        if( $email == "" ){
            $return_value = "Not Allowed";
        }

        return $return_value;
    }
}