<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


global $mod_strings;

$module_menu[] = Array("index.php?module=AddonBoilerplate&action=setup", $mod_strings['SETUP_LNK'],"AddonBoilerplate");
$module_menu[] = Array("index.php?module=AddonBoilerplate&action=license", $mod_strings['ADDONBOILERPLATE_LICENSE_LNK'],"AddonBoilerplate");
