<?php
namespace local_mentor;

use dml_exception;
use stdClass;

require_once($CFG->dirroot.'/user/lib.php');


class manager {

    /** Insert the data into our database table.
     */

    public function insert_mentor(int $suspended, string $firstname, string $lastname, string $email, string $password): bool {
        global $DB;

        //condition must be reverse, because in user table there's only suspended column
        $suspended = $suspended==0 ? 1 : 0;

        $data = [
            'suspended' => $suspended,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'username' => $email,
            'email' => $email,
            'password' => hash_internal_user_password($password),
            'confirmed' => 1,
            'mnethostid' => 1,
            'timecreated' => strtotime(date('Y-m-d H:i:s')),
            'timemodified' => strtotime(date('Y-m-d H:i:s')),
            'phone1' => 0,
            'phone2' => 0,
            'auth' => "manual",
            'policyagreed' => 0,
            'deleted' => 0,
            'emailstop' => 0,
            'institution' => 0,
            'department' => 0,
            'address' => 0,
            'city' => 0,
            'country' => 0,
            'lang' => "en",
            'calendartype' => "gregorian",
            'theme' => 0,
            'timezone' => 99,
            'firstaccess' => 0,
            'lastaccess'  >= 0,
            'lastlogin' => 0,
            'currentlogin' => 0,
            'lastip' => 0,
            'secret' => 0,
            'picture' => 0,
            'descriptionformat' => 1,
            'mailformat' => 1,
            'maildigest' => 0,
            'maildisplay' => 2,
            'autosubscribe' => 1,
            'trackforums' => 0,
            'trustbitmask' => 0,
    
        ];
        
        try {
            //$DB->insert_record('user', $recordtoinsert, true);
            $userid = user_create_user($data, false, false);
            //$userid = $DB->get_record('user', ['email' => $email])->id;

            //add to role assignments
            $recordtoroleassignments->userid = $userid;
            $recordtoroleassignments->contextid = 1;
            $recordtoroleassignments->roleid = 3;
            $recordtoroleassignments->timemodified = strtotime(date('Y-m-d H:i:s'));
            $recordtoroleassignments->modifierid = 0;
            $recordtoroleassignments->component = "";
            $recordtoroleassignments->itemid = 0;
            $recordtoroleassignments->sortorder = 0;
            
            return $DB->insert_record('role_assignments', $recordtoroleassignments, false);

        } catch(dml_exception $e) {
            return false;
        }
    }

    function get_mentors(): array
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
                WHERE ra.roleid=3 and contextid=1";
        return $DB->get_records_sql($sql);
    }

    function update_mentor(int $suspended, string $firstname, string $lastname, string $email, string $password): bool {
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

    function delete_mentor($id) {
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