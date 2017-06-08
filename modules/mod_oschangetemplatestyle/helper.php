<?php 
/**
 * @package     Joomla.Site
 * @subpackage  mod_search
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Helper for mod_search
 *
 * @package     Joomla.Site
 * @subpackage  mod_them_osptravel
 * @since       1.5
 */
jimport( 'joomla.form.form' );
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
class ThemeOSptravelHelper extends T3 {
	var $_params = null;
	var $_theme_path	 = null;
	var $_theme_filter = null;
	var $_theme_exclude = null;
	var $_mainlayout_path = null;
	var $_mainlayout_filter = null;
	var $_mainlayout_exclude = null;
	var $__mainlayout_stripext=null;
	var $_t3app = null;
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $params
	 */	
	function __construct($params){
		$this->_params = $params;
		if(!defined('T3')){
			if (JError::$legacy) {
				JError::setErrorHandling(E_ERROR, 'die');
				JError::raiseError(500, JText::_('T3_MISSING_T3_PLUGIN'));
				exit;
			} else {
				throw new Exception(JText::_('T3_MISSING_T3_PLUGIN'), 500);
			}
		}
		$this->_t3app = T3::getApp();
		T3::import('depend/t3form');
		$form = new T3Form('them_osp');
		$form->loadFile(T3_PATH . '/params/template.xml');
		// theme
		$this->_theme_path = $form->getFieldAttribute('theme','directory',null,'params');
		$this->_theme_filter = $form->getFieldAttribute('theme','filter',null,'params');
		$this->_theme_exclude = $form->getFieldAttribute('theme','exclude',null,'params');
		$this->_mainlayout_path = $form->getFieldAttribute('mainlayout','directory',null,'params');
		$this->_mainlayout_filter = $form->getFieldAttribute('mainlayout','filter',null,'params');
		$this->_mainlayout_exclude = $form->getFieldAttribute('mainlayout','exclude',null,'params');
		$this->_mainlayout_stripext = $form->getFieldAttribute('mainlayout','stripext',null,'params');
	}

	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	function getTheme(){
		$options = array();
		if (!is_dir($this->_theme_path))$this->_theme_path =  T3_TEMPLATE_PATH . DIRECTORY_SEPARATOR . $this->_theme_path;
		$folders = JFolder::folders($this->_theme_path, $this->_theme_filter);
		if (is_array($folders))
			foreach ($folders as $folder){
				if ($this->_theme_exclude){ if (preg_match(chr(1) . $this->_theme_exclude . chr(1), $folder)) continue;}
				$options[] = $folder;
			}
		return $options;
	}
	
	function getMainlayout(){
		$options = array();
		if (!is_dir($this->_mainlayout_path))$this->_mainlayout_path =  T3_TEMPLATE_PATH . DIRECTORY_SEPARATOR . $this->_mainlayout_path;
		$files = JFolder::files($this->_mainlayout_path, $this->_mainlayout_filter);
		if (is_array($files))
			foreach ($files as $file){
				if ($this->_mainlayout_exclude){if (preg_match(chr(1) . $this->_mainlayout_exclude . chr(1), $file))continue;}
				if ($this->_mainlayout_stripext)$file = JFile::stripExt($file);
				$options[] = JHtml::_('select.option', $file, $file);
			}
		echo JHtml::_('select.genericlist',$options, 'mainlayout','class="inputbox"', 'value', 'text',JFactory::getApplication()->input->getCmd('mainlayout',$this->_t3app->getLayout()));
	}
	
	
}
































?>