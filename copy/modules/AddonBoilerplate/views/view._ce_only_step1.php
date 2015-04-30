<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/SugarView.php');
require_once('modules/AddonBoilerplate/clients/base/api/AddonBoilerplateApi.php');

class View_CE_Only_Step1 extends SugarView
{
    public function display()
    {
        // get MC key if it exists
        $scapi = new AddonBoilerplateApi();
        $data = $scapi->getApiKey(null,array());
        
        $this->ss->assign('apikey', (empty($data['apikey']) ? '' : $data['apikey']));

        // assign errors passed from controller
        $this->ss->assign('errors',$this->view_object_map['errors']);
        
        $this->ss->assign('step_count',1);
        
        $this->ss->display('modules/AddonBoilerplate/tpls/ce/setup/step1.tpl');
    }
}
