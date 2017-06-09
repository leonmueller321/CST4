<?php
    defined('_JEXEC') or die;
	include ('helper.php');
	include_once __DIR__ . '/helper.php';
	
	// Instantiate global document object
	$doc = JFactory::getDocument();
	
    if(isset($_GET['choosePackage'])){
        $layout = $params->get('layout', 'housepackage');
        require JModuleHelper::getLayoutPath('mod_houseconfiguration', $layout); 
    }

    else{
        
        $layout = $params->get('layout', 'default');
        require JModuleHelper::getLayoutPath('mod_houseconfiguration', $layout);
    }
  
?>