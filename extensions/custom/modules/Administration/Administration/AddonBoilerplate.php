<?php 


global $sugar_version;

$admin_option_defs=array();

if(preg_match( "/^6.*/", $sugar_version) ) {
    $admin_option_defs['Administration']['addonboilerplate_license']= array('helpInline','LBL_ADDONBOILERPLATE_LICENSE_TITLE','LBL_ADDONBOILERPLATE_LICENSE','./index.php?module=AddonBoilerplate&action=license');
    $admin_option_defs['Administration']['addonboilerplate_setup']= array('Import','LBL_ADDONBOILERPLATE_SETUP_WIZARD_TITLE','LBL_ADDONBOILERPLATE_SETUP_WIZARD','./index.php?module=AddonBoilerplate&action=setup');
} else {
    $admin_option_defs['Administration']['addonboilerplate_license']= array('helpInline','LBL_ADDONBOILERPLATE_LICENSE_TITLE','LBL_ADDONBOILERPLATE_LICENSE','javascript:parent.SUGAR.App.router.navigate("#bwc/index.php?module=AddonBoilerplate&action=license", {trigger: true});');
    $admin_option_defs['Administration']['addonboilerplate_setup']= array('Import','LBL_ADDONBOILERPLATE_SETUP_WIZARD_TITLE','LBL_ADDONBOILERPLATE_SETUP_WIZARD','javascript:parent.SUGAR.App.router.navigate("AddonBoilerplate/layout/setup", {trigger: true});');
}

$admin_group_header[]= array('LBL_ADDONBOILERPLATE','',false,$admin_option_defs, '');

