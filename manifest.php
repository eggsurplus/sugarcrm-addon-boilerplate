<?php

global $sugar_version;

$manifest = array(
    'acceptable_sugar_versions' =>
        array(
            'regex_matches' =>
            array(
                '6.*.*',
                '7.*.*',
            ),
        ),
    'acceptable_sugar_flavors' =>
        array(
            'CE',
            'PRO',
            'ENT',
            'CORP',
            'ULT',
        ),
    'author' => 'SugarOutfitters',
    'description' => 'A sample add-on that can be used to create your own',
    'icon' => '',
    'is_uninstallable' => true,
    'name'=>'SugarCRM Add-on Boilerplate',
    'published_date' => '2015-04-20',
    'type' => 'module',
    'version' => '0.000001',
    'remove_tables' => 'prompt',
);


$installdefs = array(
    'id' => 'AddonBoilerplate',
    'image_dir' => '<basepath>/icons',
    'beans' => 
        array(
            array(
                'module' => 'AddonBoilerplate',
                'class' => 'AddonBoilerplate',
                'path' => 'modules/AddonBoilerplate/AddonBoilerplate.php',
                'tab' => false,
            ),
        ),
    'copy' =>
        array(
            array(
                'from' => '<basepath>/copy/modules/AddonBoilerplate',
                'to' => 'modules/AddonBoilerplate',
            ),
        ),
    'language' =>
        array(
        // ENGLISH en_us
            array(
                'from' => '<basepath>/extensions/custom/application/Language/en_us.AddonBoilerplate.php',
                'to_module' => 'application',
                'language' => 'en_us',
            ),
            array(
                'from' => '<basepath>/extensions/custom/modules/Administration/Language/en_us.AddonBoilerplate.php',
                'to_module' => 'Administration',
                'language' => 'en_us'
            ),
            array(
                'from' => '<basepath>/extensions/custom/modules/Schedulers/Language/en_us.AddonBoilerplate.php',
                'to_module' => 'Schedulers',
                'language' => 'en_us'
            ),
        // END ENGLISH en_us
        ),
    'administration' =>
        array(
            array(
                'from'=>'<basepath>/extensions/custom/modules/Administration/Administration/AddonBoilerplate.php',
                'to' => 'modules/Administration/AddonBoilerplate.php',
            ),
        ),
    'scheduledefs' =>
        array(
            array(
                'from' => '<basepath>/extensions/custom/modules/Schedulers/ScheduledTasks/AddonBoilerplate.php',
            ),
        ),
    /** IMPLEMENT AS NEEDED
    'logic_hooks' =>
        array(
        ),
    */
    /** IMPLEMENT AS NEEDED
    'relationships' =>
        array(
            array(
                'module' => 'Accounts',
                'meta_data' => '<basepath>/relationships/addonboilerplate_accounts_MetaData.php',
            ),
        ),
    */
    /** IMPLEMENT AS NEEDED
    'layoutdefs' =>
        array(
        ),
    */
    /** IMPLEMENT AS NEEDED
    'vardefs' =>
        array(
        ),
    */
    /** IMPLEMENT AS NEEDED
    'utils' =>
        array(
        ),
    */
    /** IMPLEMENT AS NEEDED
    'entrypoints' =>
        array(
        ),
    */
);

/**
 * For legacy support add additional Sugar 6 pieces below
 * This assumes that the main installdefs is for Sugar 7.
 * In general, it is safe to install Sugar 7 code on Sugar 6 as there is no effect.
 * If there is something that may affect a Sugar 6 install use the same concept below, but for Sugar 7 specific code.
 */

// if sugar 6, install the connector, otherwise don't
//IMPLEMENT AS NEEDED
//if(preg_match( "/^6.*/", $sugar_version))
//{
//    $installdefs['connectors'] = array(
//        array(
//            'connector' => '<basepath>/copy/connectors/source/addonboilerplate',
//            'formatter' => '<basepath>/copy/connectors/formatter/addonboilerplate',
//            'name' => 'ext_rest_addonboilerplate',
//        ),
//    );
//}

