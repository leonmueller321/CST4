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
jimport('joomla.filesystem.folder');
// no direct access
defined('_JEXEC') or die('Restricted access');

class modOSContentSliderHelper {

	/**
	 * Get list articles
	 * Ver 1 : only form content
	 */
	public static function getList( &$params, $module ){
		$thumbPath = JPATH_CACHE.'/'.$module->module.'/';
		$thumbUrl  = str_replace(JPATH_BASE.'/',JURI::base(),$thumbPath);
		$defaultThumb = JURI::base().'modules/'.$module->module.'/images/no-image.jpg';	
		
		if( !is_dir($thumbPath) ) {
			JFolder::create( $thumbPath, 0755 );
		};
		//Get source form params
		$source 	= $params->get('source','category');
		if($source == 'category' || $source == 'article_ids')
		{
			$source = 'content';
		}
		else if($source == 'k2_category' || $source == 'k2_article_ids')
		{
			$source = 'k2';
		}
		else if($source == 'osproperty')
		{
			$source = 'osproperty';
		}
		else{
			$source = 'content';
		}

		$path = JPATH_SITE.'/modules/mod_os_contentslider/classes/'.$source.".php";

		require_once $path;
		$objectName = "Os".ucfirst($source)."DataSource";
	 	$object = new $objectName($params );
		//3 step
		//1.set images path
		//2.Render thumb
		//3.Get List
	 	$items = $object->setThumbPathInfo($thumbPath,$thumbUrl,$defaultThumb)
			->setImagesRendered( array( 'thumbnail' =>
										array( (int)$params->get( 'thumbnail_width', 60 ), (int)$params->get( 'thumbnail_height', 60 ))
									) )
			->getList();
		
  		return $items;
	}

	public static function fetchHead($params){
		$document	= JFactory::getDocument();
		$header = $document->getHeadData();
		$mainframe = JFactory::getApplication();
		$template = $mainframe->getTemplate();

		if(file_exists(JPATH_BASE.'/templates/'.$template.'/html/mod_os_contentslider/css/oscontentslider.css'))
		{
			$document->addStyleSheet(  JURI::root().'templates/'.$template.'/html/mod_os_contentslider/css/oscontentslider.css');
		}
		else{
			$document->addStyleSheet(JURI::root().'modules/mod_os_contentslider/tmpl/css/oscontentslider.css');
		}

		$loadJquery = true;
		switch($params->get('loadJquery',"auto")){
			case "0":
				$loadJquery = false;
				break;
			case "1":
				$loadJquery = true;
				break;
			case "auto":

				foreach($header['scripts'] as $scriptName => $scriptData)
				{
					if(substr_count($scriptName,'/jquery'))
					{
						$loadJquery = false;
						break;
					}
				}
			break;
		}
		$loadHammer = true;
		if(!$params->get('touch_screen')){
			$loadHammer = false;
		}else{
			foreach($header['scripts'] as $scriptName => $scriptData)
						{
							if(substr_count($scriptName,'/hammer.js'))
							{
								$loadHammer = false;
								break;
							}
						}
		}
		//Add js
		if($loadHammer){
			$document->addScript(JURI::root().'modules/mod_os_contentslider/tmpl/js/hammer.js');
		}
		if($loadJquery)
		{
			$document->addScript(JURI::root().'modules/mod_os_contentslider/tmpl/js/jquery.min.js');
		}
		$document->addScript(JURI::root().'modules/mod_os_contentslider/tmpl/js/slides.js');
		$document->addScript(JURI::root().'modules/mod_os_contentslider/tmpl/js/default.js');
		$document->addScript(JURI::root().'modules/mod_os_contentslider/tmpl/js/jquery.easing.1.3.js');
	}
}
?>