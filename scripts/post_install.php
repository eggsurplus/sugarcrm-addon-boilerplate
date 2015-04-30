<?php if (! defined('sugarEntry') || ! sugarEntry) die('Not A Valid Entry Point');

?>
Please be patient as the installer finishes.
<br/><br/>
You will be automatically redirected once it has completed.
<?php

function post_install() 
{
    global $sugar_version, $sugar_flavor, $db, $dictionary, $current_user;

    //install table for user management
    if (!$db->tableExists('so_users'))
    {

        $fieldDefs = array(
            'id' => array (
              'name' => 'id',
              'vname' => 'LBL_ID',
              'type' => 'id',
              'required' => true,
              'reportable' => true,
            ),
            'deleted' => array (
                'name' => 'deleted',
                'vname' => 'LBL_DELETED',
                'type' => 'bool',
                'default' => '0',
                'reportable' => false,
                'comment' => 'Record deletion indicator',
            ),
            'shortname' => array (
                'name' => 'shortname',
                'vname' => 'LBL_SHORTNAME',
                'type' => 'varchar',
                'len' => 255,
            ),
            'user_id' => array (
                'name' => 'user_id',
                'rname' => 'user_name',
                'module' => 'Users',
                'id_name' => 'user_id',
                'vname' => 'LBL_USER_ID',
                'type' => 'relate',
                'isnull' => 'false',
                'dbType' => 'id',
                'reportable' => true,
                'massupdate' => false,
            ),
        );
        
        $indices = array(
            'id' => array (
                'name' => 'so_userspk',
                'type' => 'primary',
                'fields' => array (
                    0 => 'id',
                ),
            ),
            'shortname' => array (
                'name' => 'shortname',
                'type' => 'index',
                'fields' => array (
                    0 => 'shortname',
                ),
            ),
        );
        $db->createTableParams('so_users',$fieldDefs,$indices);
    }

    //do any scheduler setup, repairs, and promotions here

    require_once('include/utils.php');
    require_once('include/utils/file_utils.php');
    require_once('config.php');
    require_once('include/MVC/Controller/SugarController.php');
    require_once('modules/ModuleBuilder/controller.php');
    require_once('modules/ModuleBuilder/parsers/ParserFactory.php');

    // install a default scheduler, default to run every 5 minutes
    $scheduler = BeanFactory::getBean('Schedulers');
    $scheduler->retrieve_by_string_fields(array('job' => 'function::AddonBoilerplate','deleted' => '0' ));
    
    //create the job if it has not yet been created
    if(empty($scheduler->id))
    {
        $job = BeanFactory::getBean('Schedulers');
        $job->name = 'AddonBoilerplate';
        $job->job = 'function::AddonBoilerplate';
        $job->date_time_start = '2005-01-01 00:00:00';
        $job->job_interval = '*/5::*::*::*::*';
        $job->status = 'Active';
        $job->catch_up = '1';
        $job->save();
    }
     
/**
    //define fields to add to the UI
    //NOTE: define these fields in the $field_defs below...needed to repair correctly
    $new_field_list = array(
        'addonboilerplate_field_c' => array(
            'name' => 'addonboilerplate_field_c',
            'label' => 'LBL_ADDONBOILERPLATE_FIELD_C',
        ),
    );
 
    $layoutFields = array();
    foreach ($new_field_list as $key => $field) {
        $layoutFields[$key] = $field;
    }
 */   
 //   if(preg_match( "/^6.*/", $sugar_version)) 
/**
    {
        addField2View('Accounts', $layoutFields, 'detailview');
        addField2View('Accounts', $layoutFields, 'editview');
    }
    else
    {
        addField2View('Accounts', $layoutFields, 'recordview');
    }

    //add to database as we are using Vardefs Ext instead of custom_fields in manifest due to: https://community.sugarcrm.com/sugarcrm/topics/custom_utils_in_sugarcrm_7_1_5_not_loading
    $field_defs = array();
    
    
    // if you edit this definition, also change /extensions/custom/modules/Accounts/Vardefs/AddonBoilerplate.php and vice versa

    $field_defs['addonboilerplate_field_c'] = array(
        'name' => 'LBL_ADDONBOILERPLATE_FIELD_C',
        'type' => 'varchar',
        'len' => 255,
    );

    $options = $db->getOptions();
    $options['skip_index_rebuild'] = true;
    $db->setOptions($options);
    
    $db->repairTableParams('accounts', $field_defs, null, true);
*/
//    if(preg_match( "/^6.*/", $sugar_version))
/**
    {
        // have use manually run rebuild & repair
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
            'rebuildExtensions',
            'clearMetadataAPICache'
        );
        $rc->repairAndClearAll($actions,array('Accounts'),true,false);
        $rc->clearAdditionalCaches();
        $GLOBALS['current_user'] = $old_user;
    }
*/
    
    
    $admin = BeanFactory::getBean('Administration');
    $admin->retrieveSettings('addonboilerplate');
    
    require_once('modules/AddonBoilerplate/includes/classes/AddonBoilerplate/Setting.php');
    
    $default_my_config = true;
    
    // if not already set, default activity sync enabled to true
    if (!isset($admin->settings['addonboilerplate_my_config']))
    {
        AddonBoilerplate_Setting::set('my_config',$default_my_config);
    }
    
    // If it's a pro+ edition, install sample report
/**
    if ($sugar_flavor != 'CE')
    {
        $report_id = 'addonboilerplate-sample-report-id123456789';
        
        $sql = "SELECT * 
                FROM saved_reports 
                WHERE id='{$report_id}'";
                
        $result = $db->query($sql);
        
        $row = $db->fetchByAssoc($result);

        // easiest way for cross-db support to check if report already exists, just run query on id
        if (empty($row)) 
        {
            // add the sample report
            // ADD THE INSERT STATEMENT HERE...
            $sql = "INSERT INTO saved_reports (..........";
            
            $result = $db->query($sql);
        }
    }
*/
    
    // add tables that are non-standard
/**
    $table_name = 'addonboilerplate_non_bean_table_example';
    if (!$db->tableExists($table_name)) 
    {
        $fieldDefs = array(
            'id' => array(
                'name' => 'id',
                'vname' => 'LBL_ID',
                'type' => 'id',
                'required' => true,
                'reportable' => true,
            ),
            'addonboilerplate_field_c' => array(
                'name' => 'addonboilerplate_field_c',
                'vname' => 'LBL_LADDONBOILERPLATE_FIELD_C',
                'type' => 'varchar',
                'len' => 255,
                'required' => true,
                'reportable' => true,
            ),
        );

        $indices = array(
            'id' => array(
                'name' => $table_name.'pk',
                'type' => 'primary',
                'fields' => array(
                    0 => 'id',
                ),
            ),
        );
        
        $db->createTableParams($table_name,$fieldDefs,$indices);
    }
*/
    

    //redirect to license page
    if(preg_match( "/^6.*/", $sugar_version)) {
        echo "
            <script>
            document.location = 'index.php?module=AddonBoilerplate&action=license';
            </script>"
        ;
    } else {
        echo "
            <script>
            var app = window.parent.SUGAR.App;
            window.parent.SUGAR.App.sync({callback: function(){
                app.router.navigate('#bwc/index.php?module=AddonBoilerplate&action=license', {trigger:true});
            }});
            </script>"
        ;
    }
}

function addField2View ($module, $layoutFields, $view) 
{
    echo "<br /><b> Updating module $module view $view with custom fields.</b><br />";   
 
    $parser = ParserFactory::getParser($view, $module);

    if (!$parser) 
    {
        $GLOBALS['log']->fatal("No parser found for $module | $view");
    }
    
    $row = $column = 0;
    foreach ($layoutFields as $field => $field_def) 
    {
        if (recursive_array_search($field,$parser->_viewdefs['panels']) !== false)
        {
            $GLOBALS['log']->fatal("$field already added to $module $view View. Not adding again.");
            echo ("<strong>$field</strong> already added to $module $view View. Not adding again.<br />");
            continue;
        }

        $parser->_viewdefs['panels']['LBL_ADDONBOILERPLATE'][$row][$column] = $field_def;
        echo ("<strong>$field</strong> field added to $module $view View.<br />");
        $column = ($column > 0) ? 0 : 1;
        if($column === 0) $row++;
    }
 
    $parser->handleSave(false);
}

function recursive_array_search($needle,$haystack) 
{
    foreach($haystack as $key=>$value) 
    {
        $current_key=$key;
        if($needle===$value || (is_array($value) && recursive_array_search($needle,$value) !== false)) 
        {
            return $current_key;
        }
    }
    return false;
}

