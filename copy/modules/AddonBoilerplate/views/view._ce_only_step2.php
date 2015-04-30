<?php if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');

require_once('include/MVC/View/SugarView.php');

class View_CE_Only_Step2 extends SugarView
{
    public function display()
    {
        // get schedulers lang file
        $scheduler_lang = return_module_language('en_us', 'Schedulers');
        
        $this->ss->assign('schedulers_LBL_CRON_INSTRUCTIONS_WINDOWS',(!empty($scheduler_lang['LBL_CRON_INSTRUCTIONS_WINDOWS']) ? $scheduler_lang['LBL_CRON_INSTRUCTIONS_WINDOWS'] : 'LBL_CRON_INSTRUCTIONS_WINDOWS'));
        $this->ss->assign('schedulers_LBL_CRON_WINDOWS_DESC',(!empty($scheduler_lang['LBL_CRON_WINDOWS_DESC']) ? $scheduler_lang['LBL_CRON_WINDOWS_DESC'] : 'LBL_CRON_WINDOWS_DESC'));
        $this->ss->assign('schedulers_LBL_CRON_INSTRUCTIONS_LINUX',(!empty($scheduler_lang['LBL_CRON_INSTRUCTIONS_LINUX']) ? $scheduler_lang['LBL_CRON_INSTRUCTIONS_LINUX'] : 'LBL_CRON_INSTRUCTIONS_LINUX'));
        $this->ss->assign('schedulers_LBL_CRON_LINUX_DESC',(!empty($scheduler_lang['LBL_CRON_LINUX_DESC']) ? $scheduler_lang['LBL_CRON_LINUX_DESC'] : 'LBL_CRON_LINUX_DESC'));

        // get scheduler data
        $scapi = new AddonBoilerplateApi();
        $data = $scapi->isSchedulerSet(null,array());

        $this->ss->assign('realpath',$data['realpath']);
        $this->ss->assign('scheduler_ran',$data['scheduler_ran']);
        $this->ss->assign('is_windows',$data['is_windows']);
        
        $this->ss->assign('step_count',2);
        
        $this->ss->display('modules/AddonBoilerplate/tpls/ce/setup/step2.tpl');
    }
}
