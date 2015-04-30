<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


require_once('include/MVC/Controller/SugarController.php');
require_once('modules/AddonBoilerplate/clients/base/api/AddonBoilerplateApi.php');

class AddonBoilerplateController extends SugarController
{
    function action_setup($errors=array())
    {
        $this->view_object_map['errors'] = $errors;
        $this->view = '_ce_only_step1';
    }
    
    function action_step1($errors=array())
    {
        $this->view_object_map['errors'] = $errors;
        $this->view = '_ce_only_step1';
    }
    
    function action_step1save()
    {
        if (empty($_REQUEST['apikey']))
        {
            // you must enter an apikey
            return $this->action_step1(array('You must provide an api key.'));
        }

        $scapi = new AddonBoilerplateApi();
        $data = $scapi->updateApiKey(null,array(
            'apikey' => $_REQUEST['apikey']
        ));
        
        if (empty($data['success']) ||  $data['success'] !== true)
        {
            // failed to connect and save
            return $this->action_step1(array('The api key failed to save: '.$data['message']));
        }
        
        $this->action_step2();
    }

    function action_step2()
    {
        $this->view = '_ce_only_step2';
    }

    function action_step3()
    {
        $this->view = '_ce_only_step3';
    }
    
    function action_step3save()
    {
        require_once('modules/AddonBoilerplate/includes/classes/AddonBoilerplate/Setting.php');
        
        AddonBoilerplate_Setting::set('my_config',$_REQUEST['my_config']);
        
        $this->action_step4();
    }

    function action_step4($errors=array())
    {
        $this->view_object_map['errors'] = $errors;
        $this->view = '_ce_only_step4';
    }

    function action_update_setting()
    {
        if (empty($_REQUEST['key']))
        {
            echo 'A key is required.'; exit;
        }
        
        $data = array();
        $data['key'] = $_REQUEST['key'];

        if (empty($_REQUEST['value']))
        {
            $data['value'] = '';
        }
        else
        {
            $data['value'] = $_REQUEST['value'];
        }

        $scapi = new AddonBoilerplateApi();
        $response = $scapi->updateSetting(null,$data);
        
        echo print_r($response,true); exit;
    }

    function action_get_setting()
    {
        if (empty($_REQUEST['key']))
        {
            echo 'A key is required.'; exit;
        }
        
        $data = array();
        $data['key'] = $_REQUEST['key'];

        $scapi = new AddonBoilerplateApi();
        $response = $scapi->getSetting(null,$data);
        
        echo print_r($response,true); exit;
    }
}

