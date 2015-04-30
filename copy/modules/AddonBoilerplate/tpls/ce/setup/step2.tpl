
{include file="modules/AddonBoilerplate/tpls/ce/setup/header.tpl"}

<script type="text/javascript">

</script>

<div class="setup-body">
    {if $scheduler_ran===true}
        <div class="setup-section setup-success hide">
            <p>Great! It looks like you have been able to set up the Scheduler in the past.</p><br>
        
            <p>To ensure that the sync will run please double check the instructions below.</p>
        
        </div>
    {else}
        <div class="setup-section setup-fail hide">
            <p>
                We noticed that the SugarCRM Scheduler has never ran.
                If you haven't already, please follow the steps below to set up the Scheduler.
                This is how we will be able to run the integration.
                Once you are done click on the "Next" button.
            </p>
        </div>
    {/if}
    
    {if $is_windows===true}
        <div id="scheduler-setup-windows" class="setup-section listViewBody hide">
            <br>
            <table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view">
                <tr height="20">
                    <th><slot>{$schedulers_LBL_CRON_INSTRUCTIONS_WINDOWS}</slot></th>
                </tr>
                <tr class="evenListRowS1">
                    <td scope="row" valign="top" width="70%"><slot>{$schedulers_LBL_CRON_WINDOWS_DESC}<br>
                        <b>cd <span class="scheduler-realpath"></span><br>
                        php.exe -f cron.php</b>
                    </slot></td>
                </tr>
            </table>
        </div>
    {else}
        <div id="scheduler-setup-linux" class="setup-section listViewBody hide">
            <br>
            <table cellpadding="0" cellspacing="0" width="100%" border="0" class="list view">
                <tr height="20">
                    <th><slot>{$schedulers_LBL_CRON_INSTRUCTIONS_LINUX}</slot></th>
                </tr>
                <tr>
                    <td scope="row" valign=TOP class="oddListRowS1" bgcolor="#fdfdfd" width="70%"><slot>
                        {$schedulers_LBL_CRON_LINUX_DESC}<br>
                        <b>*&nbsp;&nbsp;&nbsp;&nbsp;*&nbsp;&nbsp;&nbsp;&nbsp;*&nbsp;&nbsp;&nbsp;&nbsp;*&nbsp;&nbsp;&nbsp;&nbsp;*&nbsp;&nbsp;&nbsp;&nbsp;
                        cd <span class="scheduler-realpath">{$realpath}</span>; php -f cron.php > /dev/null 2>&1</b>
                        <br>
                    </slot></td>
                </tr>
            </table>
        </div>
    {/if}

    <form action="index.php" method="POST">
        <input type="hidden" name="module" value="AddonBoilerplate">
        <input type="hidden" name="action" value="step3">
        <button type="submit" class="btn btn-primary span4 pull-right" title="Next">Next</button>
        <div class="clearfix"></div>
    </form>

</div>

{include file="modules/AddonBoilerplate/tpls/ce/setup/footer.tpl"}