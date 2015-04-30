<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/SugarView.php');

class View_CE_Only_Step4 extends SugarView
{
    public function display()
    {

        // seed the errors with anything that was passed in
        $errors = (is_array($this->view_object_map['errors']) && !empty($this->view_object_map['errors'])) ? $this->view_object_map['errors'] : array();
        if ($data['success'] !== true)
        {
            $errors []= $data['message'];
        }
        $this->ss->assign('errors',$errors);
        
        $this->ss->assign('step_count',4);
        
        $this->ss->display('modules/AddonBoilerplate/tpls/ce/setup/step4.tpl');
    }
}
