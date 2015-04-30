<?php

$job_strings[] = 'AddonBoilerplate';

// run the addonboilerplate scheduler
function AddonBoilerplate()
{
    $GLOBALS['log']->fatal('The AddonBoilerplate scheduler job has ran.');
    return true;
}

