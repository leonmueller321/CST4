<?php
    defined('_JEXEC') or die;
	include ('helper.php');
	include_once __DIR__ . '/helper.php';
	
	// Instantiate global document object
	$doc = JFactory::getDocument();
	
    if(isset($_POST['submit'])){
        $layout = $params->get('layout', 'termin_success');
        require JModuleHelper::getLayoutPath('mod_termine', $layout); 
    }

    else{
        
        $layout = $params->get('layout', 'default');
        require JModuleHelper::getLayoutPath('mod_termine', $layout);
    }
  
?>