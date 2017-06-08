<?php
    defined('_JEXEC') or die;
    include ('helper.php');
	
    if(isset($_GET['choosePackage'])){
        $layout = $params->get('layout', 'form_success');
        require JModuleHelper::getLayoutPath('mod_housepackage', $layout); 
    }
	/*
	elseif(isset($_GET[choosePackage]) && isset($_GET['toList'])){
		$layout = $params->get('layout', 'form_success');
        require JModuleHelper::getLayoutPath('mod_housepackage', $layout);
	}
	*/
    else{
        
        $layout = $params->get('layout', 'default');
        require JModuleHelper::getLayoutPath('mod_housepackage', $layout);
    }
    
    
    
    
?>