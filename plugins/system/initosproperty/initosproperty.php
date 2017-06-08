<?php
/**
 * @plugin Init OS Property
 * @author Dang Thuc Dam
 * @copyright (C) Dang Thuc Dam
 * @license GNU/GPL http://joomdonation.com
**/
// no direct access-
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class  plgSystemInitOSProperty extends JPlugin
{	
	function onAfterRoute()
	{
		$mainframe = JFactory::getApplication();
		jimport('joomla.filesystem.file');
		$db = JFactory::getDbo();
		$db->setQuery("Select count(id) from #__osrs_init where `name` like 'import_city' and `value` like '1'");
		$count = $db->loadResult();
		if($count == 0){
			$db->setQuery("Select count(id) froM #__osrs_cities where country_id = '194'");
			$count = $db->loadResult();
			if($count == 0){
				$configSql = JPATH_ADMINISTRATOR.'/components/com_osproperty/sql/cities.osproperty.sql' ;
		    	$sql = JFile::read($configSql) ;
				$queries = $db->splitSql($sql);
				if (count($queries)) {
					foreach ($queries as $query) {
					$query = trim($query);
					if ($query != '' && $query{0} != '#') {
							$db->setQuery($query);
							$db->query();						
						}	
					}
				}
				$db->setQuery("Insert into #__osrs_init (id,`name`,`value`) values (NULL,'import_city','1')");
				$db->query();
			}else{
				$db->setQuery("Insert into #__osrs_init (id,`name`,`value`) values (NULL,'import_city','1')");
				$db->query();
			}
		}
	}
}