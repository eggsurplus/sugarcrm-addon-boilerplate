<?php

$moduleName = 'AddonBoilerplate';
$viewdefs[$moduleName]['base']['menu']['header'] = array(
    array(
        'label' =>'LNK_SETUP',
        'acl_action'=>'setup',
        'acl_module'=>$moduleName,
        'icon' => 'icon-plus',
        'route'=>'#'.$moduleName.'/layout/setup',
    ),
);
