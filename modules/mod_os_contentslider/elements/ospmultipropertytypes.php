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
jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldOSPMultipropertytypes extends JFormFieldList {
	protected $type = 'OSPMultipropertytypes'; //the form field type
    var $options = array();

    protected function getOptions() {

		$path = JPATH_ROOT . '/components/com_osproperty';
        if (is_dir($path)) {        
			$db = JFactory::getDBO();
			
			// generating query
			$db->setQuery("SELECT id as value, type_name as text from #__osrs_types where published = '1' order by type_name");
			// getting results
			$results = $db->loadObjectList();
			
			if(count($results)){
				// iterating
				$temp_options = array();
				
				foreach ($results as $item) {
					array_push($temp_options, array($item->value, $item->text));	
				}

				foreach ($temp_options as $option) {
					$this->options[] = JHtml::_('select.option', $option[0], $option[1]);
				}		

				return $this->options;
			}
		}
        return $this->options;
		
	}
 	// bind function to save
    function bind( $array, $ignore = '' ) {
        if (key_exists( 'field-name', $array ) && is_array( $array['field-name'] )) {
        	$array['field-name'] = implode( ',', $array['field-name'] );
        }
        
        return parent::bind( $array, $ignore );
    }
}
