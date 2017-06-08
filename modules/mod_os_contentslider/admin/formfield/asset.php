<?php
/**
 * @package 	mod_os_contentslider - OS ContentSlider Module
 * @version		1
 * @created		July 2013

 * @author		Dang Thuc Dam
 * @email		damdt@joomservices.com
 * @website		http://joomservice.com
 * @support		http://joomservice.com
 * @copyright	Copyright (C) 2013 Joomdonation. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.form.formfield');

class JFormFieldAsset extends JFormField {

    protected $type = 'Asset';

    protected function getInput() {
		JHTML::_('behavior.framework');	
		$document	= &JFactory::getDocument();		
		if (!version_compare(JVERSION, '3.0', 'ge')) {
			$checkJqueryLoaded = false;
			$header = $document->getHeadData();
			foreach($header['scripts'] as $scriptName => $scriptData)
			{
				if(substr_count($scriptName,'/jquery')){
					$checkJqueryLoaded = true;
				}
			}
				
			//Add js
			if(!$checkJqueryLoaded) 
			$document->addScript(JURI::root().$this->element['path'].'js/jquery.min.js');
			$document->addScript(JURI::root().$this->element['path'].'js/chosen.jquery.min.js');		
			$document->addScript(JURI::root().$this->element['path'].'js/colorpicker/colorpicker.js');
			$document->addScript(JURI::root().$this->element['path'].'js/javascript.js');

			//Add css         
			$document->addStyleSheet(JURI::root().$this->element['path'].'css/style.css');
			$document->addStyleSheet(JURI::root().$this->element['path'].'js/colorpicker/colorpicker.css');        
			$document->addStyleSheet(JURI::root().$this->element['path'].'css/chosen.css');        
			$document->addStyleDeclaration('.switcher-yes,.switcher-no{background-image:url('.JURI::root().JText::_('YESNO_IMAGE').')}');
		
		}else{
			$document->addScript(JURI::root().$this->element['path'].'js/colorpicker/colorpicker.js');
			$document->addScript(JURI::root().$this->element['path'].'js/javascript.js');
			//Add css         
			$document->addStyleSheet(JURI::root().$this->element['path'].'css/style.css');
			$document->addStyleSheet(JURI::root().$this->element['path'].'js/colorpicker/colorpicker.css'); 
		
		}
        
        return null;
    }
}
?>