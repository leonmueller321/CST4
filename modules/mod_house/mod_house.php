<?php
    defined('_JEXEC') or die;

	include_once __DIR__ . '/helper.php';
	
	// Instantiate global document object
	$doc = JFactory::getDocument();
	
    if(isset($_GET['choosePackage'])){
        $layout = $params->get('layout', 'form_success');
        require JModuleHelper::getLayoutPath('mod_house', $layout); 
    }

    else{
        
        $layout = $params->get('layout', 'default');
        require JModuleHelper::getLayoutPath('mod_house', $layout);
    }
  
?>