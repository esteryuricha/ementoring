<?php

function local_boostnavigation_extend_navigation(global_navigation $navigation) {
    global $CFG, $PAGE, $COURSE, $USER, $DB;

    // Fetch config.
    $config = get_config('local_boostnavigation');

    //remove site home
    $homenode = $navigation->find('home', global_navigation::TYPE_ROOTNODE);
    $homenode->showinflatnavigation = false;

    //remove private files
    $privatefiles = $navigation->find('privatefiles', global_navigation::TYPE_SETTING);
    $privatefiles->showinflatnavigation = false;

    //remove content bank 
    $contentbank = $navigation->find('contentbank', global_navigation::TYPE_CUSTOM);
    $contentbank->showinflatnavigation = false;

    //remove my course menu
    $mycoursesnode = $navigation->find('mycourses', global_navigation::TYPE_ROOTNODE);
    $mycoursesnode->showinflatnavigation = false;
    
    $mycourseschildrennodeskeys = $mycoursesnode->get_children_key_list();
    foreach ($mycourseschildrennodeskeys as $k) {
        $mycoursesnode->find($k, null)->showinflatnavigation = false;
    }

    if ($PAGE->context->get_course_context(false) == true && $COURSE->id != SITEID) {
        //remove badge node
        // $badgesnode = $navigation->find('badgesview', global_navigation::TYPE_SETTING)->remove();

        //remove competencies node
        // $competenciesnode = $navigation->find('competencies', global_navigation::TYPE_SETTING)->remove();

        //remove grade node
        $gradesnode = $navigation->find('grades', global_navigation::TYPE_SETTING)->remove();

        //remove participant node
        $participantsnode = $navigation->find('participants', global_navigation::TYPE_CONTAINER)->remove();
    }

    //get role
    $role_assignment = $DB->get_record_sql("select r.id from {role} r inner join {role_assignments} ra on r.id = ra.roleid where ra.userid=$USER->id");

    //add menu class for mentor and participant
    if($role_assignment->id == 3 || $role_assignment->id == 5) {
        $nodeclass = $navigation->add('Courses', new moodle_url($CFG->wwwroot.'/local/class/'), navigation_node::NODETYPE_BRANCH, null, null, new pix_icon('i/folder', null));
        $nodeclass->showinflatnavigation = true;
    }


    //admin and manager menu only 
    if (!has_capability('moodle/site:configview', context_system::instance())) {
        
        if($role_assignment->id != 1) {
            return;
        }else{

        }
    }

    $node1 = $navigation->add('Users', null, navigation_node::NODETYPE_BRANCH, null, null, new pix_icon('i/group', null));
    $node1->showinflatnavigation = true;

    $node11 = $node1->add('Mentors', new moodle_url($CFG->wwwroot.'/local/mentor/'), navigation_node::NODETYPE_LEAF, null, null, null);
    $node11->showinflatnavigation = true;

    $node12 = $node1->add('Participants', new moodle_url($CFG->wwwroot.'/local/participant/'),navigation_node::NODETYPE_LEAF, null, null, null);
    $node12->showinflatnavigation = true;

    $node13 = $node1->add('Managers',  new moodle_url($CFG->wwwroot.'/local/manager/'), navigation_node::NODETYPE_LEAF, null, null, null);
    $node13->showinflatnavigation = true;

    $node2 = $navigation->add('Programs', new moodle_url($CFG->wwwroot.'/local/event/'), navigation_node::NODETYPE_BRANCH, null, null, new pix_icon('i/flagged', null));
    $node2->showinflatnavigation = true;

    $node3 = $navigation->add('Courses', new moodle_url($CFG->wwwroot.'/local/class/'), navigation_node::NODETYPE_BRANCH, null, null, new pix_icon('i/folder', null));
    $node3->showinflatnavigation = true;

    $node4 = $navigation->add('Statistics', new moodle_url($CFG->wwwroot.'/local/statistic/'), navigation_node::NODETYPE_BRANCH, null, null, new pix_icon('i/outcomes', null));
    $node4->showinflatnavigation = true;
} 