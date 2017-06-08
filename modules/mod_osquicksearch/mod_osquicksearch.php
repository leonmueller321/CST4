<?php
/**
 * @subpackage  mod_osquicksearch
 * @author      Dang Thuc Dam
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
error_reporting(0);
require_once __DIR__ . '/helper.php';
$doc =  JFactory::getDocument();
require_once JPATH_ROOT.'/components/com_osproperty/helpers/helper.php' ;
OSPHelper::loadBootstrap();
$module_name             = basename(dirname(__FILE__));
$url = JURI::base(true) . '/modules/' . $module_name . '/asset/';
$doc->addStyleSheet($url . 'style.css');

$module_position = $params->get('module_position',0);
$osp_type        = $params->get('osp_type');
$distance 		 = $params->get('distance',0);
if(count($osp_type) > 0)
{
	$extra_sql = " and id in (".implode(",", $osp_type).")";
}

$db = JFactory::getDbo();
$db->setQuery("Select * from #__osrs_types where published = '1' $extra_sql");
$types = $db->loadObjectList();

$db->setQuery("Select fieldvalue from #__osrs_configuration where fieldname like 'price_filter_type'");
$price_filter_type = $db->loadResult();
global $configClass;
$configClass['price_filter_type'] = $price_filter_type;

// number bath room
$nbath = JRequest::getVar('nbath',0);
$bathArr[] = JHtml::_('select.option','',JText::_('OS_BATHS'));
for($i=1;$i<=5;$i++){
	$bathArr[] = JHtml::_('select.option',$i,$i.'+');
}
$lists['nbath'] = JHtml::_('select.genericlist',$bathArr,'nbath',' class="input-mini"','value','text',$nbath);

//number bed room
$nbed = JRequest::getVar('nbed',0);
$lists['nbed'] = $nbed;
$bedArr[] = JHtml::_('select.option','',JText::_('OS_BEDS'));
for($i=1;$i<=5;$i++){
	$bedArr[] = JHtml::_('select.option',$i,$i.'+');
}
$lists['nbed'] = JHtml::_('select.genericlist',$bedArr,'nbed','class="input-mini" ','value','text',$nbed);

//number bed room
$nroom = JRequest::getVar('nroom',0);
$lists['room'] = $nroom;
$roomArr[] = JHtml::_('select.option','',JText::_('OS_ROOMS'));
for($i=1;$i<=5;$i++){
	$roomArr[] = JHtml::_('select.option',$i,$i.'+');
}
$lists['nroom'] = JHtml::_('select.genericlist',$roomArr,'nroom','class="input-mini" ','value','text',$nroom);


require JModuleHelper::getLayoutPath('mod_osquicksearch');

?>
