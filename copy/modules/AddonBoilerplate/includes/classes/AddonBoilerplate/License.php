<?php

require_once('modules/AddonBoilerplate/license/OutfittersLicense.php');        

class AddonBoilerplate_License
{
    public static function is_valid()
    {
        $result = AddonBoilerplateOutfittersLicense::isValid('AddonBoilerplate');

        if ($result !== true)
        {
            //The license didn't validate as the subscription has expired for the user. Handle it how you would like below
            $admin = BeanFactory::getBean('Administration');
            $admin->retrieveSettings('addonboilerplate');
            $last_sent = $admin->settings['addonboilerplate_licenseemail'];

            $elapsed = (60 * 60);
            
            if (empty($last_sent) || ($last_sent + $elapsed) < time())
            {
                $admin->saveSetting('addonboilerplate','licenseemail',time());
                
                require_once('modules/AddonBoilerplate/includes/classes/AddonBoilerplate/Helper.php');
                global $sugar_config, $sugar_version, $sugar_flavor;

                $error_email = AddonBoilerplate_Helper::get_error_email_address();

/**
                //send email to the admin user
                $email_to = $error_email;
                $subject =  '[CRITICAL] AddonBoilerplate is no longer functioning';
                $bodyHTML= "
The license was unable to validate. Please log into your SugarCRM instance, go to Admin->AddonBoilerplate->License Configuration and validate your license.

Site: ".$sugar_config['site_url']."
SugarCRM Version: ".$sugar_version."
SugarCRM Edition: ".$sugar_flavor."
AddonBoilerplate Version: ".AddonBoilerplate_Helper::get_addonboilerplate_version();
        
                AddonBoilerplate_Helper::send_email($email_to,$subject,$bodyHTML,'help@addonboilerplate.com');
*/
                
                return $result;
            }
        }
        
        return $result;
    }
}