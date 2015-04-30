<?php

class AddonBoilerplate_sugar extends Basic {
    var $new_schema = true;
    var $module_dir = 'AddonBoilerplate';
    var $object_name = 'AddonBoilerplate';
    var $table_name = 'addonboilerplate';

    var $id;
    var $name;
    
    function AddonBoilerplate_sugar(){ 
        parent::Basic();
    }
    
    function bean_implements($interface){
        switch($interface){
            case 'ACL': return true;
        }
        return false;
    }
        
}
