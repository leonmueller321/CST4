<?php

defined('_JEXEC') or die;
	
	include('model/housepackage.class.php');
	include('model/level.class.php');
	
	class modHouseconfigurationHelper{		
			public static function getComponentsMethodAjax(){
				include_once JPATH_ROOT . '/components/com_content/helpers/route.php';
				
				//get data from ajax post
				$data = $_REQUEST['levelid'];
				
				//decode json string
				$levelid = json_decode($data);

				
				return "levelid = " + $levelid;
			}
	}
	
	class Database{
		
		private $db;
		private $housepackageArray = array();
		private $elementArray = array();
        private $levelsArray = array();
		
		//get all housepackages as array of objects
		function getAllHousepackages(){

			$db= JFactory::getDbo();
			$query = $db->getQuery(true);
                        
			$query->select(array('id','name', 'description', 'area', 'floors', 'img_path'));
			$query->from($db->quoteName('house_packages'));
			$db->setQuery($query);
			
			$result = $db->loadAssocList();
			
			foreach($result as $item){
				$h = new Housepackage(
						$item['id'],
						$item['name'],
						$item['description'],
                        $item['area'],
                        $item['floors'],
                        $item['img_path']
				);
                               
				array_push($this->housepackageArray, $h);
			}
			return $this->housepackageArray;
		}
		
		//get a housepackage by id
		function getHousePackage($houseid){
			// Get a db connection.
			$db = JFactory::getDbo();
			 
			// Get the chosen house
			$query = $db->getQuery(true);
			$query->select(array('id','name', 'description', 'area', 'floors', 'img_path'));
			$query->from($db->quoteName('house_packages'));
			$query->where($db->quoteName('id')." = ".$db->quote($houseid));
			
			$db->setQuery($query);
			$row = $db->loadObject();
			
			$h = new Housepackage(
					$row->id,
					$row->name,
					$row->description,
					$row->area,
					$row->floors,
					$row->img_path
			);
			
			return $h;
		}
		
		
		//get components from housepackage id
		
		
		//get Levels
		function getLevels($houseid){
			// Get a db connection.
			$db = JFactory::getDbo();
			 
			
			$query = $db->getQuery(true);
			$query->select(array('id','name', 'area', 'sketch', 'height'));
			$query->from($db->quoteName('levels'));
			$query->where($db->quoteName('house_package_id')." = ".$db->quote($houseid));
			$db->setQuery($query);
			
			$result = $db->loadAssocList();
			
			foreach($result as $item){
				$l = new Level(
						$item['id'],
						$item['name'],
						$item['area'],
                        $item['sketch'],
                        $item['height']
				);
                               
				array_push($this->levelsArray, $l);	
			}
			return $this->levelsArray;
		}
		
	}
		
		/*
                
                 * $query->select(array('a.id','a.name', 'a.description', 'a.area', 'a.floors', 'a.image_path', 
                                                'b.id', 'b.name','b.area', 'b.sketch', 'b.height'));
                        //$query->select(array();
			$query->from($db->quoteName('house_packages', 'a'))
                              ->join('INNER', $db->quoteName('levels', 'b') . ' ON(' . $db->quoteName('a.id') . '=' . $db->quoteName('b.house_package_id'));
			
                 *  $l = new Level(
                                        $item['b.id'],
                                        $item['b.name'],
                                        $item['b.area'],
                                        $item['b.sketch'],
                                        $item['b.height']
                                        );
                 * $JSON = json_encode(array('housepackage' => $housepackageArray) )
                 
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
		
		
		
		*/
	
	/*
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
				
				
				return "houseid= ".$houseconfig->houseid." userid= ".$user->id;
			}
	}
	
	
    class Database{
		
		private $db;
		private $housepackageArray = array();
		private $elementArray = array();
                private $levelArray = array();
		
		//get all housepackages as array of objects
		function getAllHousepackages(){

			$db= JFactory::getDbo();
			$query = $db->getQuery(true);
                        
			$query->select(array('id','name', 'description', 'area', 'floors', 'image_path'));
			$query->from($db->quoteName('house_packages'));
			$db->setQuery($query);
			
			$result = $db->loadAssocList();
			
			foreach($result as $item){
				$h = new Housepackage(
						$item['id'],
						$item['name'],
						$item['description'],
                                                $item['area'],
                                                $item['floors'],
                                                $item['image_path']
				);
                               
				array_push($this->housepackageArray, $h);
			}
			return $this->housepackageArray;
		}
		/*
                
                 * $query->select(array('a.id','a.name', 'a.description', 'a.area', 'a.floors', 'a.image_path', 
                                                'b.id', 'b.name','b.area', 'b.sketch', 'b.height'));
                        //$query->select(array();
			$query->from($db->quoteName('house_packages', 'a'))
                              ->join('INNER', $db->quoteName('levels', 'b') . ' ON(' . $db->quoteName('a.id') . '=' . $db->quoteName('b.house_package_id'));
			
                 *  $l = new Level(
                                        $item['b.id'],
                                        $item['b.name'],
                                        $item['b.area'],
                                        $item['b.sketch'],
                                        $item['b.height']
                                        );
                 * $JSON = json_encode(array('housepackage' => $housepackageArray) )
                 
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
			$query->from($db->quoteName('houses'));
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
		
		*/
	
    
    
 ?>

