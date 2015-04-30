<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


global $sugar_version;

// only load the real SugarApi for sugar 6.7.*, 7, and above users
// otherwise, load a fake one so it can still be extended and not throw error in CE
if(preg_match( "/^6.[0-6]/", $sugar_version))
{
    //needed to trick the system to make a single code base work across major versions of Sugar
    require_once('modules/AddonBoilerplate/includes/classes/CEHackSugarApi.php');
}
else
{
    require_once('include/api/SugarApi.php');
}

require_once('data/BeanFactory.php');
require_once('modules/AddonBoilerplate/includes/classes/AddonBoilerplate/Helper.php');
require_once('modules/AddonBoilerplate/includes/classes/AddonBoilerplate/Setting.php');

class AddonBoilerplateApi extends SugarApi
{
    public function registerApiRest()
    {
        return array(
            'getApiKey' => array(
                'reqType' => 'GET',
                'path' => array('AddonBoilerplate', 'apikey'),
                'pathVars' => array(''),
                'method' => 'getApiKey',
                'shortHelp' => 'Retrieves the AddonBoilerplate API key',
            ),
            'updateApiKey' => array(
                'reqType'   => 'POST',
                'path'      => array('AddonBoilerplate','apikey','update'),
                'pathVars'  => array(''),
                'method'    => 'updateApiKey',
                'shortHelp' => 'This method saves the AddonBoilerplate API key.',
            ),
            'isSchedulerSet' => array(
                'reqType' => 'GET',
                'path' => array('AddonBoilerplate', 'scheduler'),
                'pathVars' => array(''),
                'method' => 'isSchedulerSet',
                'shortHelp' => 'Checks to see if the SugarCRM scheduler has been set up.',
            ),
            'updateSetting' => array(
                'reqType'   => 'POST',
                'path'      => array('AddonBoilerplate','setting','?','?'),
                'pathVars'  => array('','','key','value'),
                'method'    => 'updateSetting',
                'shortHelp' => 'Update a sugarcrm setting key to a given value.',
            ),
            'getSetting' => array(
                'reqType'   => 'GET',
                'path'      => array('AddonBoilerplate','setting','?'),
                'pathVars'  => array('','','key'),
                'method'    => 'getSetting',
                'shortHelp' => 'Get a sugarcrm setting key value.',
            ),
        );
    }
    
    public function getApiKey($api, array $args)
    {
        $apikey = AddonBoilerplate_Setting::retrieve('apikey');
        return array('apikey'=>$apikey);
    }
    
    public function updateApiKey($api, array $args)
    {
        if (empty($args['apikey'])) {
            throw new SugarApiExceptionMissingParameter('ERR_MISSING_PARAMETER_FIELD', array('apikey'), 'AddonBoilerplate');
        }

        //test the key by pinging the remote API
        //YOUR TEST CODE HERE
        $return = true; //dummy data
        
        // sugar 6 has a weird issue where saveSetting returns 0 if the setting doesn't change
        // if apikey in config is what's provided, return success
        global $sugar_version;
        if(preg_match( "/^6.*/", $sugar_version))
        {
            $current_apikey = $this->getApiKey($api,array());
            if (!empty($current_apikey['apikey']) && $current_apikey['apikey']==$args['apikey'])
            {
                return array('success' => true,'message'=>'Saving key was successful.');
            }
        }
        
        $admin = BeanFactory::getBean('Administration');
        $return = $admin->saveSetting('addonboilerplate', 'apikey', trim($args['apikey']));
        
        return array('success' => (!empty($return)),'message'=>'Saving key was '.(!empty($return)?'successful':'unsuccessful').'.');
    }

    
    public function isSchedulerSet($api, array $args)
    {
        global $sugar_flavor;
        
        // if it's CE, always show scheduler data
        if ($sugar_flavor != 'CE' && AddonBoilerplate_Helper::is_ondemand_instance() === true)
        {
            return array('ondemand'=>true,'scheduler_ran'=>'','is_windows'=>'','realpath'=>'');
        }
        
        $scheduler_ran = false;
        $instructions = '';
        
        $scheduler = BeanFactory::getBean('Schedulers');
        $scheduler_list = $scheduler->get_list('','last_run is not null');
        
        if(!empty($scheduler_list) && $scheduler_list['row_count'] > 0) {
            $scheduler_ran = true;
        }
    
        if (!isset($_SERVER['Path'])) {
            $_SERVER['Path'] = getenv('Path');
        }
        
    
        return array('ondemand'=>false,'scheduler_ran'=>$scheduler_ran,'is_windows'=>is_windows(),'realpath'=>SUGAR_PATH);
    }
    
    public function updateSetting($api,$args)
    {
        if (empty($args['key']))
        {
            AddonBoilerplate_Helper::log('error','AddonBoilerplateAPI->updateSetting a key is required to update the setting.');
            return array('success'=>false,'message'=>'A key is required to update a setting.');
        }
        
        if (empty($args['value']))
        {
            $args['value'] = '';
            AddonBoilerplate_Helper::log('warning','AddonBoilerplateAPI->updateSetting value is empty. will set '.$key.' to empty value.');
        }
        
        $key = $args['key'];
        $value = $args['value'];
        
        $result = AddonBoilerplate_Setting::set($key,$value);

        if ($result !== true)
        {
            return array(
                'success' => false,
                'message' => 'The setting could not be saved.',
            );
        }

        return array(
            'success' => true,
            'message' => 'The setting was successfully updated.',
        );
    }

    public function getSetting($api,$args)
    {
        if (empty($args['key']))
        {
            AddonBoilerplate_Helper::log('error','AddonBoilerplateAPI->updateSetting a key is required to update the setting.');
            return array('success'=>false,'message'=>'A key is required to update a setting.');
        }
        
        $key = $args['key'];
        
        require_once('modules/AddonBoilerplate/includes/classes/AddonBoilerplate/Setting.php');
        $result = AddonBoilerplate_Setting::retrieve($key);

        if ($result === false)
        {
            return array(
                'success' => false,
                'message' => 'The setting could not be retrieved.',
                'value' => $result,
            );
        }

        return array(
            'success' => true,
            'message' => 'The setting was retrieved successfully.',
            'value' => $result,
        );
    }
}