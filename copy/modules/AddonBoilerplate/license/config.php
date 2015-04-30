<?php

$outfitters_config = array(
    'name' => 'AddonBoilerplate',
    'shortname' => 'AddonBoilerplate', //The short name of the Add-on. e.g. For the url https://www.sugaroutfitters.com/addons/sugaroutfitters the shortname would be sugaroutfitters
    'public_key' => '71796449b84dfa83f48929cdc4281323', //The public key associated with the group
    'api_url' => 'https://www.sugaroutfitters.com/api/v1',
    'validate_users' => false,
    'validation_frequency' => 'weekly', //default: weekly options: hourly, daily, weekly
    'continue_url' => '#AddonBoilerplate/layout/setup', //[optional] Will show a button after license validation that will redirect to this page. Could be used to redirect to a configuration page such as index.php?module=MyCustomModule&action=config
);

global $sugar_version;

if(preg_match( "/^6.*/", $sugar_version) ) {
    $outfitters_config['continue_url'] = 'index.php?module=AddonBoilerplate&action=setup';
}
