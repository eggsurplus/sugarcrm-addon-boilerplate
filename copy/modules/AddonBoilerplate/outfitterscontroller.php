<?php

    
if(empty($_REQUEST['method'])) {
    header('HTTP/1.1 400 Bad Request');
    $response = "method is required.";
    $json = getJSONobj();
    echo $json->encode($response);
}


//load license validation config
global $currentModule;
require_once('modules/'.$currentModule.'/license/OutfittersLicense.php');

if($_REQUEST['method'] == 'validate') {
    AddonBoilerplateOutfittersLicense::validate();
} else if($_REQUEST['method'] == 'change') {
    AddonBoilerplateOutfittersLicense::change();
} else if($_REQUEST['method'] == 'add') {
    AddonBoilerplateOutfittersLicense::add();
} else if($_REQUEST['method'] == 'test') {
    //optional param: user_id - test if a specific user has access to the add-on
    //Sugar 6: /index.php?module=SampleLicenseAddon&action=outfitterscontroller&method=test&to_pdf=1
    //Sugar 7: #bwc/index.php?module=SampleLicenseAddon&action=outfitterscontroller&method=test&to_pdf=1
    
    $user_id = null;
    if(!empty($_REQUEST['user_id'])) {
        $user_id = $_REQUEST['user_id'];
    }
    $validate_license = AddonBoilerplateOutfittersLicense::isValid($currentModule,$user_id,true);

    if($validate_license !== true) {

        echo "License did NOT validate.<br/><br/>Reason: ".$validate_license;
        
        
        $validated = AddonBoilerplateOutfittersLicense::doValidate($currentModule);
        
        if(is_array($validated['result'])) {
            echo "<br/><br/>Key validation = ".!empty($validated['result']['validated']);
            require('modules/'.$currentModule.'/license/config.php');

            if($outfitters_config['validate_users'] == true) {
                echo "<br/>User validation = ".!empty($validated['result']['validated_users']);
                echo "<br/>Licensed User Count = ".$validated['result']['licensed_user_count'];
                echo "<br/>Current User Count = ".$validated['result']['user_count'];

                if($validated['result']['user_count'] > $validated['result']['licensed_user_count']) {
                    echo "<br/><br/>Additional Users Required = ".($validated['result']['user_count'] - $validated['result']['licensed_user_count']);
                }
            }
        }
        
    } else {
        echo "License validated";
    }
}
