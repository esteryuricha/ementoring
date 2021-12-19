<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Right Sidebar for Profile
 *
 * @package   block_courseinformation
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_courseinformation extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_courseinformation');
    }

    function has_config() {
        return true;
    }

    function get_content() {
        global $USER, $DB;

        if ($this->content !== NULL) {
            return $this->content;
        }

        $id = optional_param('id', null, PARAM_INT);

        $content = "";

        //get role
        $role_assignment = $DB->get_record_sql("select r.id from {role} r inner join {role_assignments} ra on r.id = ra.roleid where ra.userid=$USER->id");

        if( $role_assignment->id == 5 )
        {
            //show group
            $group = $DB->get_record_sql("SELECT g.id, g.name FROM {groups} g JOIN {groups_members} gm ON g.id = gm.groupid WHERE gm.userid = $USER->id and g.courseid = $id");
            
            if($group){
            $groupid = $group->id;
            
            $content = "<b>My Team : $group->name</b><br>";

            $groupmembers = $DB->get_records_sql("SELECT u.firstname, u.lastname, u.email FROM {groups_members} gm JOIN {user} u ON gm.userid = u.id WHERE gm.groupid = $groupid and userid!=$USER->id");

            foreach( $groupmembers as $groupmember ) {
                $content .= $groupmember->firstname." (".$groupmember->email.")<br>";
            }
            }
        }else{
            if($id) {
                //get all groups
                $groups = $DB->get_records_sql("SELECT g.id, g.name FROM {groups} g JOIN {groups_members} gm ON g.id = gm.groupid WHERE g.courseid = $id");

                $content = "<b>Teams Count : ".count($groups)."</b><br>";

                foreach( $groups as $index => $group ) {
                    $content .= "<b>".$group->name."</b><br>";
                    
                    $groupmembers = $DB->get_records_sql("SELECT u.firstname, u.lastname, u.email FROM {groups_members} gm JOIN {user} u ON gm.userid = u.id WHERE gm.groupid = $group->id");
                
                    foreach( $groupmembers as $groupmember ) {
                        $content .= "* ".$groupmember->firstname." (".$groupmember->email.")<br>";
                    }
                }
            }
        }

        $this->content = new stdClass;
        $this->content->text = $content;
        $this->content->footer = "";
        return $this->content;
        
    }

}
