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

        $content = "My Group<br>";

            $this->content = new stdClass;
            $this->content->text = $content;
            $this->content->footer = "";
            return $this->content;
        
    }

}
