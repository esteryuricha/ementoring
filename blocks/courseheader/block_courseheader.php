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
 * @package   block_courseheader
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_courseheader extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_courseheader');
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
        $courseUrl = new moodle_url($CFG->wwwroot.'/course/view.php?id='.$id);
        $participantUrl = new moodle_url($CFG->wwwroot.'/user/index.php?id='.$id);
        $gradeUrl = new moodle_url($CFG->wwwroot.'/grade/report/grader/index.php?id='.$id);
        $groupUrl = new moodle_url($CFG->wwwroot.'/group/index.php?id='.$id);

        $content = "";
        $content .= "<button type='button' class='btn btn-primary' onclick='location.href=\"$courseUrl\"'>Course</button>";
        $content .= "<button type='button' class='btn btn-primary' onclick='location.href=\"$participantUrl\"'>Participants</button>";
        $content .= "<button type='button' class='btn btn-primary' onclick='location.href=\"$gradeUrl\"'>Grades</button>";
        $content .= "<button type='button' class='btn btn-primary' onclick='location.href=\"$courseUrl\"'>Schedule</button>";
        $content .= "<button type='button' class='btn btn-primary' onclick='location.href=\"$groupUrl\"'>Groups</button>";

            $this->content = new stdClass;
            $this->content->text = $content;
            $this->content->footer = "";
            return $this->content;
        
    }

}
