
{include file="modules/AddonBoilerplate/tpls/ce/setup/header.tpl"}

<div class="setup-body">
    {foreach from=$errors key=error_key item=error_message}
        <div class="setup-section error">
            <p>{$error_message}</p>
        </div>
    {/foreach}

    <div class="setup-section">
        <p>This setting means nothing, but choose a value anyway.</p>
        <br/>

        <form action="index.php" method="POST">
            <input type="hidden" name="module" value="AddonBoilerplate">
            <input type="hidden" name="action" value="step3save">

            <div>
                <label for="my_config">My config</label>
                <select name="my_config" id="my_config" class="width-inherit">
                    <option value="true" {if $my_config == 'true'}selected="selected"{/if}>Yes</option>
                    <option value="false" {if $my_config == 'false'}selected="selected"{/if}>No</option>
                </select>
            </div>

            <button class="nextStep btn btn-primary btn-large pull-right">Next</button>
        </form>
    </div>
</div>

{include file="modules/AddonBoilerplate/tpls/ce/setup/footer.tpl"}