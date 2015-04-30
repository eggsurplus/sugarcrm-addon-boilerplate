<?php if (! defined('sugarEntry') || ! sugarEntry) die('Not A Valid Entry Point');

?>
Cleaning up some configurations...
<?php

post_uninstall();

function post_uninstall() 
{
    global $db, $sugar_version, $sugar_flavor;

    // delete the AddonBoilerplate scheduler
    $delete_query = "DELETE FROM schedulers WHERE job = 'function::AddonBoilerplate'";
    $db->query($delete_query);

    global $current_user;
 
    // Add fields to the views
    /**
    require_once('include/utils.php');
    require_once('include/utils/file_utils.php');
    require_once('config.php');
    require_once('include/MVC/Controller/SugarController.php');
    require_once('modules/ModuleBuilder/controller.php');
    require_once('modules/ModuleBuilder/parsers/ParserFactory.php');
 
    //remove the AddonBoilerplate panel from views
    if(preg_match( "/^6.*/", $sugar_version)) 
    {
        removeViewPanel('Accounts','detailview');
        removeViewPanel('Accounts','editview');
    }
    else
    {
        removeViewPanel('Accounts','recordview');
    }

    if(preg_match( "/^6.*/", $sugar_version)) 
    {
        
    }
    else
    {
        //now repair the ServiceDictionary.rest.php
        $old_user = $GLOBALS['current_user'];
        $user = new User();
        $GLOBALS['current_user'] = $user->getSystemUser();

        $_REQUEST['repair_silent']=1;
        $rc = new RepairAndClear();
        $actions = array(
            'clearAll',
            //'rebuildExtensions', //if not doing a clearAll
            'clearMetadataAPICache',
            //'rebuildExtensions'
        );
        $rc->repairAndClearAll($actions,array('Accounts'),true,false);
        $rc->clearAdditionalCaches();
        $GLOBALS['current_user'] = $old_user;
    }
    */
    
    // if not CE, remove any sample reports
    /**
    if ($sugar_flavor != 'CE')
    {
        $report_id = 'addonboilerplate-sample-report-id123456789';
    
        $sql = "DELETE FROM saved_reports 
                WHERE id='{$report_id}'";
            
        $result = $db->query($sql);
    }
    */
    
    echo "AddonBoilerplate configurations have been removed.";
}

function removeViewPanel ($module, $view) {
    echo "<br /><b> Removing module $module view $view with custom fields.</b><br />";   
 
    $parser = ParserFactory::getParser($view, $module);

    if (!$parser) {
        $GLOBALS['log']->fatal("No parser found for $module | $view");
    }
    
    unset($parser->_viewdefs['panels']['LBL_ADDONBOILERPLATE']);
 
    $parser->handleSave(false);
}