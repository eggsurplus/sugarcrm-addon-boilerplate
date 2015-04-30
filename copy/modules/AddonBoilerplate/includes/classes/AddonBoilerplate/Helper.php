<?php

require_once('modules/AddonBoilerplate/includes/classes/AddonBoilerplate/Setting.php');

class AddonBoilerplate_Helper
{
    // an abstracted log method AddonBoilerplate module will use
    // hope to be able to independently set the addonboilerplate log
    public static function log($level,$message)
    {
        $message = 'AddonBoilerplate:'.$level.':'.time().': '.$message;
        
        // addonboilerplate_logger can be set on status page
        $addonboilerplate_logger = AddonBoilerplate_Setting::retrieve('logger');
        
        // if 'debug', all addonboilerplate messages are logged at 'fatal' level
        // this allows you to run addonboilerplate on debug mode and the rest of the system at any other level
        // if not 'debug', run on level provided in call
        if (!empty($addonboilerplate_logger) && $addonboilerplate_logger == 'debug')
        {
            $GLOBALS['log']->fatal($message);
        }
        else
        {
            switch ($level) 
            {
                case 'debug':
                    $GLOBALS['log']->debug($message);
                    break;
                case 'info':
                    $GLOBALS['log']->info($message);
                    break;
                case 'deprecated':
                    $GLOBALS['log']->deprecated($message);
                    break;
                case 'warn':
                    $GLOBALS['log']->warn($message);
                    break;
                case 'error':
                    $GLOBALS['log']->error($message);
                    break;
                case 'fatal':
                    $GLOBALS['log']->fatal($message);
                    break;
                case 'security':
                    $GLOBALS['log']->security($message);
                    break;
                default:
                    $GLOBALS['log']->debug($message);
                    break;
            }
        }
    }

    public static function get_addonboilerplate_version()
    {
        $addonboilerplate_version = 'unknown';
        
        /** //fails due to no deleted column
        $upgrade_history = BeanFactory::getBean('UpgradeHistory');
        $upgrade_history->retrieve_by_string_fields(array('id_name' => 'AddonBoilerplate'));        
        if ($upgrade_history->id)
        {
            $addonboilerplate_version = $upgrade_history->version;
        }
        */
        global $db;
        $result = $db->query("select version from upgrade_history where id_name = 'AddonBoilerplate' order by date_entered DESC");
        $row = $db->fetchByAssoc($result);
        if (!empty($row)) {
            $addonboilerplate_version = $row['version'];
        }
        
        return $addonboilerplate_version;
    }
    
    public static function email_support($error_message,$data)
    {
        global $sugar_config, $sugar_version, $sugar_flavor;

        $systemUser = BeanFactory::getBean("Users");
        $systemUser->getSystemUser();

        $systemUserInfo = $systemUser->getUsersNameAndEmail();

        $error_email = AddonBoilerplate_Helper::get_error_email_address();
        
        $email_to = 'help@addonboilerplate.com';
        $subject =  '[production:error] AddonBoilerplate sync failure';
        $bodyHTML= "
Site: ".$sugar_config['site_url']."
Admin Email: ".$error_email."|".$systemUserInfo['name']."
SugarCRM Version: ".$sugar_version."
SugarCRM Edition: ".$sugar_flavor."
AddonBoilerplate Version: ".AddonBoilerplate_Helper::get_addonboilerplate_version()."

Error: $error_message
Remaining data: ".print_r($data,true)."
";
        
        return AddonBoilerplate_Helper::send_email($email_to,$subject,$bodyHTML);
    }
    
    /**
     * @param $email_to email address to send to
     * @param $subject subject of the email
     * @param $bodyHTML HTML body content
     * @param $bcc (Optional) email address to bcc
     */
    public static function send_email($email_to,$subject,$bodyHTML,$bcc=null)
    {
        try {
            global $sugar_config, $sugar_version, $sugar_flavor;

            require_once("modules/Emails/Email.php");
            $body = wordwrap($bodyHTML, 900);
            $_REQUEST['sendDescription'] = htmlentities($body);
            // Email Settings
            $send_config = array(
                'sendTo' => $email_to,
                'saveToSugar' => false,
                'sendSubject' => $subject,
                'sendCc' => '',
                'sendBcc' => '',
            );
            if (!empty($bcc))
            {
                $send_config['sendBcc'] = $bcc;
            }
            $email = new Email();
            $email->email2init();
            //sending email
            if (!$email->email2Send($send_config))
            {
                AddonBoilerplate_Helper::log('fatal',"AddonBoilerplate error. Something pretty major is going on and we are trying to email ".$email_to." about something pretty major. Please forward this message along: Subject: ".$subject." Body: ".$body);
                return false;
            }
        } catch(Exception $e) {
            AddonBoilerplate_Helper::log('fatal',"AddonBoilerplate error. Something pretty major is going on and we are trying to email ".$email_to." about something pretty major. Please forward this message along: Subject: ".$subject." Body: ".$body.". General email error: ".$e->getMessage());
            return false;
        }
        
        return true;
    }
    
    public static function get_error_email_address()
    {
        $error_email = AddonBoilerplate_Setting::retrieve('erroremail');

        if (!empty($error_email))
        {
            self::log('debug','AddonBoilerplate_Helper::get_error_email_address found email in settings: '.$error_email);
            return $error_email;
        }

        self::log('debug','AddonBoilerplate_Helper::get_error_email_address could not find email in settings, getting system user.');
        
        $systemUser = BeanFactory::getBean("Users");
        $systemUser->getSystemUser();
        $systemUserInfo = $systemUser->getUsersNameAndEmail();
        
        self::log('debug','AddonBoilerplate_Helper::get_error_email_address found system email: '.$systemUserInfo['email']);
        
        AddonBoilerplate_Setting::set('erroremail',$systemUserInfo['email']);
        
        return $systemUserInfo['email'];
    }
    
    public static function is_ondemand_instance()
    {
        global $sugar_config;
        
        if (strpos($sugar_config['site_url'],'ondemand') !== false)
        {
            return true;
        }
        
        if (strpos($sugar_config['site_url'],'sugaropencloud') !== false) 
        {
            return true;
        }
        
        return false;
    }
}