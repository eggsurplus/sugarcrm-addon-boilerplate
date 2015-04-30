<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/SugarView.php');

class View_CE_Only_Step3 extends SugarView
{
    public function display()
    {
        $scapi = new AddonBoilerplateApi();
        $data = $scapi->getSetting(null,array('key'=>'my_config'));

        $errors = array();
        if ($data['success'] !== true)
        {
            $errors []= $data['message'];
        }
        $this->ss->assign('errors',$errors);

        $this->ss->assign('my_config',$data['value']);
        
        $this->ss->assign('step_count',3);
        
        $this->ss->display('modules/AddonBoilerplate/tpls/ce/setup/step3.tpl');
    }
}
