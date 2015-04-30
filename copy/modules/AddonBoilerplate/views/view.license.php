<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/SugarView.php');

class ViewLicense extends SugarView
{

    protected function _getModuleTitleParams($browserTitle = false)
    {
        global $mod_strings;

        return array(
           "<a href='index.php?module=Administration&action=index'>".translate('LBL_MODULE_NAME','Administration')."</a>",
           translate('LBL_ADDONBOILERPLATE','Administration').': '.translate('LBL_ADDONBOILERPLATE_LICENSE_TITLE','Administration'),
           );
    }


    public function preDisplay()
    {
        global $current_user;

        if(!is_admin($current_user)) {
            sugar_die("Unauthorized access to administration.");
        }
    }

    public function display()
    {
        global $current_user, $app_strings, $sugar_config, $currentModule, $sugar_version;

        //load license validation config
        require_once('modules/'.$currentModule.'/license/config.php');

        echo $this->getModuleTitle();

        $GLOBALS['log']->info("License Configuration");

        //$this->ss->assign("MOD", $mod_strings);
        //$this->ss->assign("APP", $app_strings);
        
        //todo: redirect appropriately
        $this->ss->assign("RETURN_MODULE", "Administration");
        $this->ss->assign("RETURN_ACTION", "index");
    
        $this->ss->assign("MODULE", $currentModule);
        
        $license_strings = ViewLicense::loadLicenseStrings();
        $this->ss->assign("LICENSE", $license_strings);
        if(!empty($sugar_config['outfitters_licenses']) && !empty($sugar_config['outfitters_licenses'][$outfitters_config['shortname']])) {
            $this->ss->assign("license_key", $sugar_config['outfitters_licenses'][$outfitters_config['shortname']]);
        }
        $this->ss->assign("continue_url",$outfitters_config['continue_url']);

        $this->ss->assign("file_path", getJSPath("modules/".$currentModule."/license/lib/jquery-1.7.1.min.js"));

        if(preg_match( "/^6.*/", $sugar_version) ) {
            $this->ss->assign("IS_SUGAR_6",true);
        } else {
            $this->ss->assign("IS_SUGAR_6",false);
        }

        if(!function_exists('curl_init')){
            global $current_language;
            $admin_mod_strings = return_module_language($current_language, 'Administration');
            $curl_not_enabled = $admin_mod_strings['ERR_ENABLE_CURL'];
            $this->ss->assign("CURL_NOT_ENABLED",$curl_not_enabled);
        }

        if(isset($outfitters_config['validate_users']) && $outfitters_config['validate_users'] == true) {
            $this->ss->assign("validate_users", true);
            //get user count for all active, non-portal, non-group users
            $active_users = get_user_array(FALSE,'Active','',false,'',' AND portal_only=0 AND is_group=0');
            $this->ss->assign("current_users", count($active_users));
            $this->ss->assign("user_count_param", "user_count: '".count($active_users)."'");
        } else {
            $this->ss->assign("validate_users", false);
            $this->ss->assign("current_users", '');
            $this->ss->assign("user_count_param", '');
        }
        
        if(isset($outfitters_config['manage_licensed_users']) && $outfitters_config['manage_licensed_users'] == true) {
            $this->ss->assign("manage_licensed_users", true);
            $this->ss->assign("validation_required", true);
            
            //check if here is a key already...if so then validate to ensure latest licensed user count is pulled in
            require_once('modules/Administration/Administration.php');
            $administration = new Administration();
            $administration->retrieveSettings();
            
            $last_validation = $administration->settings['SugarOutfitters_'.$outfitters_config['shortname']];

            $trimmed_last = trim($last_validation);
            //only run a license check if one has been done in the past            
            if(!empty($trimmed_last))
            {
                //if new then don't do
                require_once('modules/'.$currentModule.'/license/OutfittersLicense.php');

                $validated = OutfittersLicense::doValidate($currentModule);

                $store = array(
                    'last_ran' => time(),
                    'last_result' => $validated,
                );

                $serialized = base64_encode(serialize($store));
                $administration->saveSetting('SugarOutfitters', $outfitters_config['shortname'], $serialized);

                $licensed_users = 0;
                //check last validation
                if(!empty($validated['result']))
                {
                    $licensed_users = $validated['result']['licensed_user_count'];
                    if(!is_numeric($licensed_users)) {
                        $licensed_users = 0;
                    }
                    $this->ss->assign("validation_required", false);
                }
            }
            $this->ss->assign("licensed_users", $licensed_users);
            
            require_once('include/templates/TemplateGroupChooser.php');
            $chooser = new TemplateGroupChooser();

            $chooser->args['id'] = 'edit_licensed_users';
            $chooser->args['values_array'] = array();
            $chooser->args['values_array'][0] = get_user_array(false, 'Active', '', false, '', " AND is_group=0");
            $chooser->args['values_array'][1] = array();
            
            $used_licenses = 0;
            global $db,$locale;
            $result = $db->query("SELECT users.id, users.user_name, users.first_name, users.last_name FROM so_users INNER JOIN users ON so_users.user_id = users.id WHERE shortname = '".$db->quote($outfitters_config['shortname'])."'",false);
            while($row = $db->fetchByAssoc($result))
            {
                $used_licenses++;
                $display_name = $row['user_name'];
                if(showFullName()) {
                    if(isset($row['last_name'])) { // cn: we will ALWAYS have both first_name and last_name (empty value if blank in db)
                        $display_name = $locale->getLocaleFormattedName($row['first_name'],$row['last_name']);
                    }
                }
                $chooser->args['values_array'][1][$row['id']] = $display_name;
                unset($chooser->args['values_array'][0][$row['id']]);
            }
            $this->ss->assign("available_licensed_users", $licensed_users - $used_licenses);

            $chooser->args['left_name'] = 'unlicensed_users';
            $chooser->args['right_name'] = 'licensed_users';

            $chooser->args['left_label'] =  $license_strings['LBL_UNLICENSED_USER_LIST'];
            $chooser->args['right_label'] =  $license_strings['LBL_LICENSED_USER_LIST'];
            
            $chooser->args['title'] =  '';

            $this->ss->assign('USER_CHOOSER', $chooser->display());
            $this->ss->assign('CHOOSER_SCRIPT','set_chooser();');
            $this->ss->assign('CHOOSE_WHICH', '');
        } else {
            $this->ss->assign("manage_licensed_users", false);
        }
        
        $this->ss->display('modules/'.$currentModule.'/license/tpls/license.tpl');
    }
    
    protected static function loadLicenseStrings()
    {
        global $sugar_config, $currentModule, $current_language;
        
        //load license config file....if it isn't broken don't fix it
        $default_language = $sugar_config['default_language'];

        $langs = array();
        if ($current_language != 'en_us') {
            $langs[] = 'en_us';
        }
        if ($default_language != 'en_us' && $current_language != $default_language) {
            $langs[] = $default_language;
        }
        $langs[] = $current_language;

        foreach ( $langs as $lang ) {
            $license_strings = array();
            if(!@include("modules/".$currentModule."/license/language/$lang.lang.php")) {
                //do nothing...lang file could not be found
            }

            $license_strings_array[] = $license_strings;
        }

        $license_strings = array();
        foreach ( $license_strings_array as $license_strings_item ) {
            $license_strings = sugarArrayMerge($license_strings, $license_strings_item);
        }
        
        return $license_strings;
    }
}
