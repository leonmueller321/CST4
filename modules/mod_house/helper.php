<?php
    defined('_JEXEC') or die;
	
	include('model/housepackage.class.php');
	include('model/element.class.php');
	
	
	class modHouseHelper{		
			public static function superAwesomeMethodAjax(){
				include_once JPATH_ROOT . '/components/com_content/helpers/route.php';
				
				//get data from ajax post
				$data = $_REQUEST['json'];
				
				//decode json string
				$houseconfig = json_decode($data);
				
				//Get Current User
				$user = JFactory::getUser();
	
				//connect to db
				$db = JFactory::getDbo();
				$query = $db->getQuery(true);
				
				//insert houseconfiguration from user 
				/*
				$query
					->select($db->quoteName(array('','','')))
					->from($db->quoteName()
				*/
				
				return "houseid= ".$houseconfig->houseid." userid= ".$user->id;
			}
	}
	
	
    class Database{
		
		private $db;
		private $housepackageArray = array();
		private $elementArray = array();

		
		//get all housepackages as array of objects
		function getAllHousepackages(){

			$db= JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select(array('houseid','name', 'description'));
			$query->from($db->quoteName('houses_old'));
			
			$db->setQuery($query);
			
			$result = $db->loadAssocList();
			
			foreach($result as $item){
				$h = new Housepackage(
						$item['houseid'],
						$item['name'],
						$item['description']
				);
				array_push($this->housepackageArray, $h);
			}
			return $this->housepackageArray;
		}
		
		//get all elements
		function getAllElements(){
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select(array('elementid','name', 'preis'));
			$query->from($db->quoteName('elements'));
			
			$db->setQuery($query);
			
			$result = $db->loadAssocList();
			
			foreach($result as $item){
				$e = new Element(
						$item['elementid'],
						$item['name'],
						$item['preis']
				);
				array_push($this->elementArray, $e);
			}
			return $this->elementArray;
		}
		
		
		function getElement($elementid){
			$db = JFactory::getDbo();

			$query = $db->getQuery(true);
			$query->select(array('elementid','name', 'preis'));
			$query->from($db->quoteName('elements'));
			$query->where($db->quoteName('elementid')." = ".$db->quote($elementid));
			
			$db->setQuery($query);
			$row = $db->loadObject();
			
			$e = new Element(
					$row->elementid,
					$row->name,
					$row->preis
			);
			
			return $e;
		}
		
		//get a housepackage by idate
		function getHousePackage($houseid){
			// Get a db connection.
			$db = JFactory::getDbo();
			 
			// Get the chosen house
			$query = $db->getQuery(true);
			$query->select(array('houseid','name', 'description'));
			$query->from($db->quoteName('houses_old'));
			$query->where($db->quoteName('houseid')." = ".$db->quote($houseid));
			
			$db->setQuery($query);
			$row = $db->loadObject();
			
			$h = new Housepackage(
					$row->houseid,
					$row->name,
					$row->description
			);
			
			return $h;
		}
		
		
	}
    
    
 ?>