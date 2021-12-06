<?php
if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configcheckbox('block_sidebarprofile/showprofiles', 
            get_string('showprofile', 'block_sidebarprofile'), 
            get_string('showprofiledescription', 'block_sidebarprofile'), 
            1));   
}