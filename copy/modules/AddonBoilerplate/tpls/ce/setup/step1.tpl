
{include file="modules/AddonBoilerplate/tpls/ce/setup/header.tpl"}

<div class="setup-body tcenter">
    {foreach from=$errors key=error_key item=error_message}
        <div class="setup-section error">
            <p>{$error_message}</p>
        </div>
    {/foreach}
    
    <div class="setup-section">
        <h3>Welcome to AddonBoilerplate! Let's get started below...</h3>
        <form action="index.php" method="POST">
            <input type="hidden" name="module" value="AddonBoilerplate">
            <input type="hidden" name="action" value="step1save">
            <p>
                <label for="apikey">Your Integration's API Key:</label>
                <input type="text" id="apikey" name="apikey" value="{$apikey}" class="span8" size="50" />
                <button type="submit" class="testLogin btn btn-primary span4" title="Connect to App">Connect to App</button>
            </p>
        </form>
    </div>
    
    <div class="setup-section">
        <h3>Need help?</h3>
        <p>Here is a place to offer users some <a href="http://www.example.com" target="_blank">additional help</a>.</p>
    </div>
</div>

{include file="modules/AddonBoilerplate/tpls/ce/setup/footer.tpl"}