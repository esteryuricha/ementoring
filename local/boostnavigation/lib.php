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

    //admin menu only 
    if (!has_capability('moodle/site:configview', context_system::instance())) {
        $role_assignment = $DB->get_record_sql("select r.id from {role} r inner join {role_assignments} ra on r.id = ra.roleid where ra.userid=$USER->id");
        
        if($role_assignment->id != 1){
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

    $node3 = $navigation->add('Classes', new moodle_url($CFG->wwwroot.'/local/class/'), navigation_node::NODETYPE_BRANCH, null, null, new pix_icon('i/folder', null));
    $node3->showinflatnavigation = true;

    $node4 = $navigation->add('Statistics', null, navigation_node::NODETYPE_BRANCH, null, null, new pix_icon('i/outcomes', null));
    $node4->showinflatnavigation = true;

    // $strfoo = get_string('message', 'local_message');
    // $main_node = $navigation->add('Management Panel', '/course/editcategory.php?parent=0', navigation_node::NODETYPE_LEAF, 'message', 'message',new pix_icon('i/settings', $strfoo));
    // $main_node->nodetype = 1;
    // $main_node->collapse = false;
    // $main_node->forceopen = true;
    // $main_node->isexpandable = true;
    // $main_node->showinflatnavigation = true;    
}
 
