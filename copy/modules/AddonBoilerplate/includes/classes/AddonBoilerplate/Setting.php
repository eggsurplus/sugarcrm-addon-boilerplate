<?php

require_once('modules/AddonBoilerplate/includes/classes/AddonBoilerplate/Helper.php');

class AddonBoilerplate_Setting
{
    protected static $setting_group = 'addonboilerplate';
    protected static $default_logger_value = 'normal';
    
    public static function set($key,$value='')
    {
        if (empty($key))
        {
            AddonBoilerplate_Helper::log('warning','AddonBoilerplate_Setting::set key is required to save a setting value');
            return false;
        }
        
        if (empty($value))
        {
            AddonBoilerplate_Helper::log('debug','AddonBoilerplate_Setting::set '.$key.' is being set to an empty value');
        }
        
        // sugar 6 has a weird issue where saveSetting returns 0 if the setting doesn't change
        // if value already saved in config is what's provided, return success
        global $sugar_version;
        if(preg_match( "/^6.*/", $sugar_version))
        {
            $admin = BeanFactory::getBean('Administration');
            $admin->retrieveSettings(static::$setting_group);
            $current_value = empty($admin->settings[static::$setting_group.'_'.$key]) ? false : $admin->settings[static::$setting_group.'_'.$key];

            if (!empty($current_value) && $current_value==$value)
            {
                AddonBoilerplate_Helper::log('debug','AddonBoilerplate_Setting::set in sugar 6.* special case, '.$key.' has not changed so not saving again.');
                return true;
            }
        }
        
        $admin = BeanFactory::getBean('Administration');
        $response = $admin->saveSetting(static::$setting_group, $key, $value);
        
        if (!empty($response) !== true)
        {
            AddonBoilerplate_Helper::log('error','AddonBoilerplate_Setting::set '.$key.' value could not be saved. See sugar logs for more details.');
            return false;
        }

        AddonBoilerplate_Helper::log('debug','AddonBoilerplate_Setting::set '.$key.' saved. value: '.print_r($value,true));
        return true;
    }
    
    public static function retrieve($key)
    {
        if (empty($key))
        {
            AddonBoilerplate_Helper::log('warning','AddonBoilerplate_Setting::get key is required to retrieve a setting value');
            return false;
        }
        
        $admin = BeanFactory::getBean('Administration');
        $admin->retrieveSettings(static::$setting_group);

        $full_key = static::$setting_group.'_'.$key;

        if (!isset($admin->settings[$full_key]))
        {
            // in the case the logger level isn't set, set it to the default value
            // otherwise it will get in infinite loop in the log method when it comes back here
            if ($key=="logger")
            {
                static::set('logger',static::$default_logger_value);
                return static::$default_logger_value;
            }

            AddonBoilerplate_Helper::log('error','AddonBoilerplate_Setting::get a setting value does not exist for '.$full_key);
            return false;
        }
        
        return $admin->settings[$full_key];
    }
}