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
require_once 'ossource.php';

/**
 * OspropertyDataSource Class
 */

include_once JPATH_ROOT.'/components/com_osproperty/helpers/helper.php';
include_once JPATH_ROOT.'/components/com_osproperty/helpers/route.php';
include_once JPATH_ROOT.'/components/com_osproperty/helpers/common.php';
if(!class_exists('OsOspropertyDataSource')){
class OsOspropertyDataSource extends OsSource {

		public function getList() {
			if (!is_file(JPATH_SITE . "/components/com_osproperty/osproperty.php")) {
				return array();
			}
	
			$params = &$this->_params;
	
			/* title */
			$show_title = $params->get('show_title', 1);
	
			$titleMaxChars = $params->get('title_max_chars', '100');
			$limit_title_by = $params->get('limit_title_by', 'char');
			$replacer = $params->get('replacer', '...');
			$isStrips = $params->get("auto_strip_tags", 1);
			$stringtags = '';
			if ($isStrips) {
				$allow_tags = $params->get("allow_tags", 'br');
				$stringtags = '';
				if(!is_array($allow_tags)){
					$allow_tags = explode(',',$allow_tags);
				}
				foreach ($allow_tags as $tag) {
					$stringtags .= '<' . $tag . '>';
				}
			}
	        if (!$params->get('default_thumb', 1)) {
	            $this->_defaultThumb = '';
	        }
	
			/* intro */
			$show_intro = $params->get('show_intro', 1);
	
			$maxDesciption = $params->get('description_max_chars', 100);
	
			$limitDescriptionBy = $params->get('limit_description_by', 'char');
	
	
			$ordering = $params->get('ordering', 'created-desc');
			if ($ordering == 'publish_up-asc')
				$ordering = 'created-asc';
				
			if ($ordering == 'ordering-asc')
				$ordering = 'pro_name-asc';
	
			if ($ordering == 'ordering-desc')
				$ordering = 'pro_name-desc';
				
			if ($ordering == 'publish_up-desc')
				$ordering = 'created-desc';
				
			if ($ordering == 'featured-')
				$ordering = 'isFeatured-desc';
				
			$limit = $params->get('limit_items', 12);
	
			// Set ordering
			$ordering = explode('-', $ordering);
			if (trim($ordering[0]) == 'rand') {
				$ordering = ' RAND() ';
			}
			else {
				$ordering = 'a.'.$ordering[0] . ' ' . $ordering[1];
			}
	
			$show_category 	= $params->get('show_category',0);
			$show_type 		= $params->get('show_type',0);
			$show_address 	= $params->get('show_address',0);
			$show_price		= $params->get('show_price',0);
			
			//check user access to articles
			$user = &JFactory::getUser();
	
			$isThumb = $params->get('image_thumb', 1);
	
			$thumbWidth = (int) $params->get('thumbnail_width', 280);
			$thumbHeight = (int) $params->get('thumbnail_height', 150);
	
			$isStripedTags = $params->get('auto_strip_tags', 0);
	
			$extraURL = $params->get('open_target') != 'modalbox' ? '' : '&tmpl=component';
	
			$db = &JFactory::getDBO();
			$date = &JFactory::getDate();
			$now = $date->toSql();
	
			$dateFormat = $params->get('date_format', 'DATE_FORMAT_LC3');
	
			$show_author = $params->get('show_author', 0);
			
			$user = JFactory::getUser();
			$agent_id_permission = 0;
			if($user->id > 0){
				if(HelperOspropertyCommon::isAgent()){
					$agent_id_permission = HelperOspropertyCommon::getAgentID();
				}
			}
			if($agent_id_permission > 0){
                $access .= ' and ((a.access IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')) or (a.agent_id = "'.$agent_id_permission.'"))';
            }else {
                $access .= ' and a.access IN (' . implode(',', JFactory::getUser()->getAuthorisedViewLevels()) . ')';
            }
	
			$query = "SELECT a.*,c.type_name,d.country_name,e.state_name,q.name as agent_name FROM #__osrs_properties AS a "
					." LEFT JOIN #__osrs_types AS c ON c.id = a.pro_type"
					." INNER JOIN #__osrs_countries AS d ON  d.id = a.country"
					." LEFT JOIN #__osrs_states AS e ON e.id = a.state"
					." LEFT JOIN #__osrs_cities AS l ON l.id = a.city"
					." INNER JOIN #__osrs_agents AS q ON q.id = a.agent_id";
			$query .= " WHERE a.published = 1 AND a.approved = 1 " . $access ;
			
			$featured_property = $params->get('featured_property',0);
			if($featured_property == 1){
				$query .= " AND a.isFeatured = '1'";
			}
			$data= array();
	
			$source = trim($this->_params->get('source', 'osproperty'));
			$catids = $source == 'osproperty' ? self::getCategoryIds():'';
			$typeids = $source == 'osproperty' ? self::getTypeIds():'';
			$stateids = $source == 'osproperty' ? self::getStateIds():'';
			$cityids = $source == 'osproperty' ? self::getCityIds():'';
			$proids = $source == 'osproperty' ? self::getProIds():'';
		
	        $condition = $this->buildConditionQuery($source,$catids,$typeids,$stateids,$cityids,$proids);
	        $db->setQuery($query . $condition . ' ORDER BY ' . $ordering . ($limit ? ' LIMIT ' . $limit : ''));
	        
	        $data = array_merge($data, $db->loadObjectlist());
	
			foreach ($data as $key => &$item) {
				$needs = array();
				$needs[] = "property_details";
				$needs[] = $item->id;
				$itemid = OSPRoute::getItemid($needs);
				$item->link = JRoute::_("index.php?option=com_osproperty&task=property_details&id=" . $item->id."&Itemid=".$itemid);
	
				$item->date = JHtml::_('date', $item->created, JText::_($dateFormat));
	
				//title cut
				if ($limit_title_by == 'word' && $titleMaxChars > 0) {
	
					$item->title_cut = self::substrword($item->pro_name, $titleMaxChars, $replacer, $isStrips);
	
				}
				elseif ($limit_title_by == 'char' && $titleMaxChars > 0) {
	
					$item->title_cut = self::substring(OSPHelper::getLanguageFieldValue($item,'pro_name'), $titleMaxChars, $replacer, $isStrips);
	
				}
	
				$item->title = htmlspecialchars($item->pro_name);
	
				if ($limitDescriptionBy == 'word') {
	
					$item->description = self::substrword(OSPHelper::getLanguageFieldValue($item,'pro_small_desc'), $maxDesciption, $replacer, $isStrips, $stringtags);
	
				}
				else {
					$item->description = self::substring(OSPHelper::getLanguageFieldValue($item,'pro_small_desc'), $maxDesciption, $replacer, $isStrips, $stringtags);
				}
	
				if(($show_address == 1) and ($item->show_address == 1)){
					//$item->address = OSPHelper::generateAddress($item);
				}
				if($show_price == 1){
					if($item->price_call == 1){
						$item->price = JText::_('CALL_FOR_PRICE');
					}else{
						$item->price = JText::_('PRICE').": ".HelperOspropertyCommon::loadCurrency($item->curr)." ".HelperOspropertyCommon::showPrice($item->price);
					}
				}
				
				//$db->setQuery("Select * from #__osrs_categories where id = '$item->category_id'");
				//$category = $db->loadObject();
				///$category_name = OSPHelper::getLanguageFieldValue($category,'category_name');
				$item->category_name = OSPHelper::getCategoryNamesOfProperty($item->id);
				
				$db->setQuery("Select * from #__osrs_types where id = '$item->pro_type'");
				$type = $db->loadObject();
				$type_name = OSPHelper::getLanguageFieldValue($type,'type_name');
				$item->type_name = $type_name;
				
				$item->categoryLink = JRoute::_("index.php?option=com_osproperty&task=category_details&catid=" . $item->catid);
				$item->typeLink = JRoute::_("index.php?option=com_osproperty&view=ltype&type_id=".$item->pro_type);
				
	
				//Get name author
				//If set get, else get username by userid
				if ($show_author) {
					$item->author = $item->agent_name;
	
				}
				$item->thumbnail = "";
				$item->mainImage = "";
				$item->authorLink = "#";
				$url_image = '';
				if ($params->get('show_image')) {
					$db->setQuery('Select image from #__osrs_photos WHERE pro_id = ' . $item->id . ' order by ordering');
					$image = $db->loadResult();
					if ($image == "") {
						$url_image = JURI::root().'modules/mod_os_contentslider/images/180x120-no-image.jpg';
					}else {
						if(file_exists(JPATH_ROOT. '/images/osproperty/properties/' . $item->id . '/medium/' . $image)){
							$url_image = JURI::root() . 'images/osproperty/properties/' . $item->id . '/medium/' . $image;
						}else{
							$url_image = JURI::root().'modules/mod_os_contentslider/images/180x120-no-image.jpg';
						}
					}
					$item->mainImage = $url_image;
					if ($isThumb)
						$item->thumbnail = self::renderThumb($url_image, $thumbWidth, $thumbHeight,$isThumb);
					else {
						$item->thumbnail = $url_image;
					}
				}
	
			}
	
			return $data;
		}
	
		public function buildConditionQuery($source,$catids,$typeids,$stateids,$cityids,$proids){
			if(count($catids) > 0){
				$condition .= " AND a.id IN (Select pid from #__osrs_property_categories where category_id in ('" . implode("','", $catids) . "'))";
			}
			if(count($typeids) > 0){
				$condition .= " AND c.id IN('" . implode("','", $typeids) . "')";
			}
			if($stateids != ""){
				$condition .= " AND a.state IN(" .  $stateids . ")";
			}
			if($cityids != ""){
				$condition .= " AND a.city IN(" .  $cityids. ")";
			}
			if($proids != ""){
				$condition .= " AND a.id IN( $proids)";
			}
			return $condition;
		}
		/*get category id for query function */
		function getCategoryIds(){
			$catids = array();
			if(empty($catids)){
				$catids = $this->_params->get('osp_category', array());
			}
			return $catids;
		}
		
		function getTypeIds(){
			$typeids = array();
			if(empty($typeids)){
				$typeids = $this->_params->get('osp_type', array());
			}
			return $typeids;
		}
		
		function getStateIds(){
			$stateids = '';
			if(empty($stateids)){
				$stateids = $this->_params->get('state_ids', '');
			}
			return $stateids;
		}
		
		function getCityIds(){
			$cityids = '';
			if(empty($cityids)){
				$cityids = $this->_params->get('city_ids', '');
			}
			return $cityids;
		}
		
		function getProIds(){
			$proids = '';
			if(empty($proids)){
				$proids = $this->_params->get('property_ids');
			}
			return $proids;
		}
	}
}