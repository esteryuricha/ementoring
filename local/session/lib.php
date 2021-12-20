<?php
/*
function local_session_before_footer() {
    global $DB, $USER, $SESSION;

    //get role
    $role_assignment = $DB->get_record_sql("select r.id from {role} r inner join {role_assignments} ra on r.id = ra.roleid where ra.userid=$USER->id");

    //add menu class for mentor and participant
    if($role_assignment->id == 3 || $role_assignment->id == 5) {
        $sql = "SELECT cc.id, cc.name 
                FROM {course_categories} cc 
                INNER JOIN {course} c 
                    ON cc.id = c.category 
                INNER JOIN {enrol} e 
                    ON e.courseid = c.id 
                INNER JOIN {user_enrolments} ue 
                    ON ue.enrolid = e.id 
                WHERE ue.userid = $USER->id 
                GROUP BY cc.idnumber
                ORDER BY cc.id DESC";

        $categories = $DB->get_records_sql($sql);
        
        
        echo "<div id='choosing_area'>";
        echo "Choose Program : ";
        echo "<select id='choose_category' class='choose_category'>";

        foreach($categories as $category) {
            echo "<option value='$category->id'>$category->name</option>";
        }

        echo "</select>";
        echo "</div>";
    }
}
*/