<?php

defined('_JEXEC') or die;
	//SOME TEST
	include('model/housepackage.class.php');
	include('model/level.class.php');
        include('model/component.class.php');
        include('model/build_modules.class.php');
        include('model/prices.class.php');
	
	class modHouseconfigurationHelper{		
            public static function getComponentsMethodAjax(){
                    include_once JPATH_ROOT . '/components/com_content/helpers/route.php';
                    //get data from ajax post
                    $data = $_REQUEST['levelid'];
                    //decode json string
                    $levelid = json_decode($data);
                    
                    //get all components
                    $db = JFactory::getDbo();
                    $query = $db->getQuery(true);
                    


                    return "levelid = " + $levelid;
            }
            
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

                    return "some response!";
            }
	}
	
	class Database{
		
		private $db;
		private $housepackageArray = array();
		private $elementArray = array();
                private $levelsArray = array();
                private $componentsArray = array();
                private $buildArray = array();
                private $pricesArray = array();
                
                function getAllPrices(){
                    $db= JFactory::getDbo();
			$query = $db->getQuery(true);
                        
			$query->select(array('id','price'));
			$query->from($db->quoteName('prices'));
			$db->setQuery($query);
			
			$result = $db->loadAssocList();
			
			foreach($result as $item){
                            $p = new Price(
                                $item['id'],
                                $item['price']
				);
                               
				array_push($this->pricesArray, $p);
			}
			return $this->pricesArray;
                }
		
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
                        $sql="
                            SELECT `c`.`id`, `c`.`name`, `c`.`area`, `c`.`sketch`, `c`.`height`, `a`.`id` as `house_package_id`
                            FROM `house_packages`as `a`
                            JOIN `house_package_levels` AS `b` on `a`.`id` = `b`.`house_package_id`
                            JOIN `levels` AS `c` on `b`.`level_id` = `c`.`id`
                            where `a`.`id` =".$houseid;
                       
                        $db->setQuery($sql);
			
			$result = $db->loadAssocList();
			
			foreach($result as $item){
				$l = new Level(
						$item['id'],
						$item['name'],
						$item['area'],
                                                $item['sketch'],
                                                $item['height'],
                                                $item['house_package_id']
				);
                               
				array_push($this->levelsArray, $l);	
			}
			return $this->levelsArray;
		}
                
                function getComponents(){
                    $db = JFactory::getDbo();
                    
			$query = $db->getQuery(true);
                        $query->select(array('id', 'name', 'price_id', 'build_module_id'))
                                ->from('components');
                        
                        /*
                        $query->select(array('a.id', 'a.name', 'a.price_id', 'a.build_module_id', 'b.build_id', 'b.build_name'))
                                ->from('components AS a')->join('INNER','build_modules as b ON a.build_module_id = b.build_id')
                                ->where('a.build_module_id = b.build_id');
                        */
                        $db->setQuery($query);
			$result = $db->loadAssocList();
                        
                        foreach($result as $row){
                            $c = new Component(
                                    $row['id'],
                                    $row['name'], 
                                    $row['price_id'],
                                    $row['build_module_id']
                                    );
                            array_push($this->componentsArray, $c);
                        }
                     return $this->componentsArray;
                }
                
                function getAllBuildModules(){
                    $db = JFactory::getDbo();
                    $query = $db->getQuery(true);
                    $query->select(array('id', 'name'))
                          ->from('build_modules');
                    $db->setQuery($query);
                    $result = $db->loadAssocList();
                    
                    foreach($result as $row){
                        $b = new Build_module(
                                $row['id'],
                                $row['name']
                                );
                        array_push($this->buildArray, $b);
                    }
                    
                    return $this->buildArray;
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

