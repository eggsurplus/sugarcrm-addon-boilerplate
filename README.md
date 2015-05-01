# SugarCRM Add-on Boilerplate

A starting point for creating a SugarCRM add-on. Grab it and use it for your own add-ons. This is a Sugar 7 first implementation that also works with Sugar 6.

# Current Features & Examples

* Install Wizard
* [License Key Protection](https://www.sugaroutfitters.com/selling/license)
* Scheduler Job Installation
* Default Configurations
* Admin Menu
* License Placeholder

There are more commented out capabilities to help jump start your implementation in both manifest.php and /scripts/post_install.php. Examples include conditional install based on environment version, adding fields to the UI in both Sugar 6 and 7, creating default reports, and creating non-standard (non-bean). tables. You can also do [user-based licensing](https://www.sugaroutfitters.com/selling/license) to allow for only certain users to use your add-on. 

Want something else added? Either do a pull request or [make a request](https://github.com/eggsurplus/sugarcrm-addon-boilerplate/issues/new).

# Trying It Out

If you just want to see how it works just install it by using the [Module Loader](http://support.sugarcrm.com/02_Documentation/01_Sugar_Editions/04_Sugar_Professional/Sugar_Professional_7.5/Administration_Guide/07_Developer_Tools/21_Module_Loader/). To try out the License Key validation just use this key: 46025036c925475ef44398de9204482d

# Developer Resources

There are a number of resources that you will want to keep on hand when creating your add-on. Here are a few of them.
(Please add more as you find them)

## General Resources

* [Sugar Developer Guide](http://support.sugarcrm.com/02_Documentation/04_Sugar_Developer/Sugar_Developer_Guide_7.5/)
* [Sugar Developer Blog](http://developer.sugarcrm.com/)
* [Migrating Code from Sugar 6.x to 7](http://support.sugarcrm.com/04_Knowledge_Base/02Administration/100Install/Migrating_from_Sugar_6.x_to_7/)
* [Dev Tips on SugarOutfitters](https://www.sugaroutfitters.com/blog/devtips)
* [Angel Magaña's SugarCRM Blog](http://cheleguanaco.blogspot.com/)
* [Urdhva Tech Blog](http://urdhva-tech.blogspot.com/)
* [Shane Dowling's SugarCRM Blog](http://shanedowling.com/category/php/sugarcrm/)
* [SugarCRM v7 learning resources](https://community.sugarcrm.com/sugarcrm/topics/sugarcrm_v7_learning_resources_share_yours)

## Specific Examples for Sugar 7
* [Creating an Installable Package for a Logic Hook](http://support.sugarcrm.com/02_Documentation/04_Sugar_Developer/Sugar_Developer_Guide_7.5/70_API/Application/Module_Loader/90_Package_Examples/Creating_an_Installable_Package_for_a_Logic_Hook/)
* [Creating a Layout and View for a Module](https://www.sugaroutfitters.com/blog/creating-a-layout-and-view-for-a-module-in-sugarcrm-7)
* [Creating a Custom Button](http://www.insightful.com.au/sugarcrm-how-do-i/creating-custom-button-sugar-7/)
* [Creating a Custom Intelligence Pane](http://www.insightful.com.au/sugarcrm-how-do-i/creating-custom-intelligence-pane-sugar-7/)
* [Adding a Global Menu Item](https://www.sugaroutfitters.com/blog/sugarcrm-7-adding-a-global-menu-item)
* [Passing Data to Views](https://www.sugaroutfitters.com/blog/sugarcrm-7-passing-data-to-views)
* [Extending a View](https://www.sugaroutfitters.com/blog/sugarcrm-7-extending-a-view)
* [Filter records based on parent module's dropdown field](http://urdhva-tech.blogspot.com/2014/06/filter-records-based-on-parent-modules.html)
* [Disable duplicate check on fields in Sugarcrm](http://urdhva-tech.blogspot.com/2014/06/disable-duplicate-check-on-fields-in.html)
* [How to add Subpanel top button](http://urdhva-tech.blogspot.com/2014/06/how-to-add-subpanel-top-button-on.html)
* [Directly Calling an Action](https://www.sugaroutfitters.com/blog/directly-calling-an-action-in-sugarcrm-7)
* [Adding an action to the listview](http://shanedowling.com/sugarcrm-7-adding-an-action-to-the-listview/)
* [Global Action Menus and Drawers](http://developer.sugarcrm.com/2014/07/30/global-action-menus-and-drawers-in-sugar-7/)
* [Dynamic Record View ](http://cheleguanaco.blogspot.com/2014/08/sugarcrm-customization-dynamic.html)
* [Add Field in Subpanel via Manifest](http://urdhva-tech.blogspot.in/2014/09/add-field-in-subpanel-through-manifest.html)

(Thanks [Francesca](https://twitter.com/FrancescaShiekh) for organizing much of this list!)

# Other Helpful Resources

* [Sugar 7 API Wrapper](https://github.com/spinegar/sugarcrm7-api-wrapper-class)
* [Video - Sugar 7 Dev](https://www.youtube.com/watch?v=d1q0JL1pgUI#t=1333)
* [Video - Unminified Sources, APIs, and Plugins](https://www.youtube.com/watch?v=uzSj_4BKq9o#t=396)
* [Video - Dashlets, Cache, JavaScript](https://www.youtube.com/watch?v=sraC-bCmYF0#t=289)

If you aren't familiar with Backbone.js or Handlebars you'll want to get your head wrapped around that as well:

* [Backbone.js](http://backbonejs.org/)
* [Backbone JS (Tutsplus) ](https://www.youtube.com/playlist?list=PLALjBvHjUavIAkX_drHUOTOwy-JfpJXgx)
* [Handlebars](http://handlebarsjs.com/)
* [Learn jQuery in 30 Days (Tutsplus) ](https://www.youtube.com/playlist?list=PL0D4FAC008E964390)
