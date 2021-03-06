<?php

$dictionary['AddonBoilerplate'] = array(
    'table'=>'addonboilerplate',
    'audited'=>false,
    'fields'=>array (
        'param1' => array(
            'required' => false,
            'name' => 'param1',
            'vname' => 'LBL_PARAM1',
            'type' => 'enum',
            'massupdate' => 0,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => 0,
            'audited' => false,
            'reportable' => true,
            'len' => 255,
            'size' => '20',
            'dbType' => 'varchar',
            'studio' => 'hidden',
        ),
        'param2' => array(
            'required' => false,
            'name' => 'param2',
            'vname' => 'LBL_PARAM2',
            'type' => 'enum',
            'massupdate' => 0,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => 0,
            'audited' => false,
            'reportable' => true,
            'len' => 255,
            'size' => '20',
            'dbType' => 'varchar',
            'studio' => 'hidden',
        ),
        'param3' => array(
            'required' => false,
            'name' => 'param3',
            'vname' => 'LBL_PARAM3',
            'type' => 'enum',
            'massupdate' => 0,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => 0,
            'audited' => false,
            'reportable' => true,
            'len' => 255,
            'size' => '20',
            'dbType' => 'varchar',
            'studio' => 'hidden',
        ),
        'param4' => array(
            'required' => false,
            'name' => 'param4',
            'vname' => 'LBL_PARAM4',
            'type' => 'enum',
            'massupdate' => 0,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => 0,
            'audited' => false,
            'reportable' => true,
            'len' => 255,
            'size' => '20',
            'dbType' => 'varchar',
            'studio' => 'hidden',
        ),
        'param5' => array(
            'required' => false,
            'name' => 'param5',
            'vname' => 'LBL_PARAM5',
            'type' => 'enum',
            'massupdate' => 0,
            'comments' => '',
            'help' => '',
            'importable' => 'true',
            'duplicate_merge' => 'disabled',
            'duplicate_merge_dom_value' => 0,
            'audited' => false,
            'reportable' => true,
            'len' => 255,
            'size' => '20',
            'dbType' => 'varchar',
            'studio' => 'hidden',
        ),
    ),
    'relationships'=>array (
    ),
    'optimistic_lock'=>true,
);

require_once('include/SugarObjects/VardefManager.php');
VardefManager::createVardef('AddonBoilerplate','AddonBoilerplate', array('basic'));

