<?php
    defined('_JEXEC') or die;
	
    if(isset($_GET['somParameter'])){
        $layout = $params->get('layout', 'custom_example');
        require JModuleHelper::getLayoutPath('mod_example', $layout); 
    }

    else{
        
        $layout = $params->get('layout', 'default');
        require JModuleHelper::getLayoutPath('mod_example', $layout);
    }
    
    
    
    
?>