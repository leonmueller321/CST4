<?php

defined('_JEXEC') or die;
	//SOME TEST
	include('model/housepackage.class.php');
	include('model/level.class.php');
        include('model/component.class.php');
        include('model/build_modules.class.php');
        include('model/prices.class.php');
        include('model/componentWithArea.class.php');
	
        
        
        function getGUID(){
            if (function_exists('com_create_guid')){
                return com_create_guid();
            }else{
                mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
                $charid = strtoupper(md5(uniqid(rand(), true)));
                $hyphen = chr(45);// "-"
                $uuid = chr(123)// "{"
                    .substr($charid, 0, 8).$hyphen
                    .substr($charid, 8, 4).$hyphen
                    .substr($charid,12, 4).$hyphen
                    .substr($charid,16, 4).$hyphen
                    .substr($charid,20,12)
                    .chr(125);// "}"
                
                $guid = substr($uuid, 1, -1);
                return $guid;
            }
        }
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
                    $componentsarray = array();
                    foreach($data->items as $item){
                        array_push($componentsarray, $item);
                    }
                    
                    $house_package_id = $houseconfig->houseid;
                    $gesamtpreis = $houseconfig->gesamtpreis;
                    //Get Current User
                    $user = JFactory::getUser();
                    $user_id = $user->id;  
                    $time = date('Y-m-d H:i:s'); 
                    $name = $houseconfig->name;
                    
                    $items = $houseconfig->items;
                    $itemsArray = array();
                    foreach($items as $item){
                        array_push($itemsArray, $item);
                    }
                    
                    $items = json_encode($itemsArray);

                    //connect to db
                    $db = JFactory::getDbo();
                    $query = $db->getQuery(true);
                    
                    //insert into houses
                    $test = new stdClass();
                    $test->user_id = $user_id;
                    $test->house_package_id = $house_package_id;
                    $test->gesamtpreis = $gesamtpreis;
                    $test->created_at = $time;
                    $test->name = $name;
                    $test->items = $items;
                    $result = JFactory::getDbo()->insertObject('houses', $test);
                    
                    $rowid = $db->getRowID($user_id, $name);

                    $id = getGUID();
                    //insert into houses
                    $test2 = new stdClass();
                    $test2->id = $id;
                    $test2->tablename = "houses";
                    $test2->rowid = $id;
                    $test2->operation = "insert";
                    $result = JFactory::getDbo()->insertObject('changelog', $test2);
                    
                    if($result == true && $user_id !=  0){
                        return "success";
                    }
                    
                    return "danger";
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
                private $componentsWithArea = array();
                private $myHouses = array();
                
                function getRowID($uid, $name){
                    $db= JFactory::getDbo();
                    $sql = $db->getQuery(true);
                    $sql= "SELECT `houses`.`id` 
                           FROM `houses` 
                           WHERE `houses`.`user_id` =".$uid."
                           AND `houses`.`name` = ".$name;
                    $db->setQuery($sql);
                    $result = $db->loadResult();
                    return $result;
                }
                
                function getHouseConfig($houseid){
                    $db= JFactory::getDbo();
                    $sql = $db->getQuery(true);
                    
                     $sql="SELECT
                          `houses`.`id` as `id`, `houses`.`name` as `name`, `houses`.`gesamtpreis` as `gesamtpreis`, 
                          `houses`.`items` as `items`, `houses`.`user_id`, `houses`.
                          `house_package_id`, `house_packages`.`img_path` 
                          FROM `houses` 
                          JOIN `house_packages` on `houses`.`house_package_id` = `house_packages`.`id` where `houses`.`id` =".$houseid;
                    
                    $db->setQuery($sql);
                    $row = $db->loadObject();
                    
                    $h = new House(
                                $row->id,
                                $row->name,
                                $row->gesamtpreis,
                                $row->house_package_id,
                                $row->user_id,
                                $row->items,
                                $row->img_path
                            );
                    
                    return $h;
                }
                
                function getHouses($userid){
                    $db= JFactory::getDbo();
                    $sql = $db->getQuery(true);
                    
                    $sql="SELECT
                          `houses`.`id` as `id`, `houses`.`name` as `name`, `houses`.`gesamtpreis` as `gesamtpreis`, 
                          `houses`.`items` as `items`, `houses`.`user_id`, `houses`.
                          `house_package_id`, `house_packages`.`img_path` 
                          FROM `houses` 
                          JOIN `house_packages` on `houses`.`house_package_id` = `house_packages`.`id` where `houses`.`user_id` =".$userid;
                    
                    $db->setQuery($sql);
                    $result = $db->loadAssocList();
                    
                    foreach($result as $item){
                        $h = new House(
                                $item['id'],
                                $item['name'],
                                $item['gesamtpreis'],
                                $item['house_package_id'],
                                $item['user_id'],
                                $item['items'],
                                $item['img_path']
                                );
                            array_push($this->myHouses, $h);
                    }
                    return $this->myHouses;
                    
                }
                
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
                
                function getComponentsWithArea(){
                    $db= JFactory::getDbo();
                    $sql = $db->getQuery(true);
                    $sql="select 
                            `components`.`id` as `id`, `components`.`name` as `name`, `components`.`area` as `area`, 
                            `build_modules`.`id` as `build_modules_id`, `build_modules`.`name` as `build_modules_name`, 
                            `prices`.`id` as `price_id` ,`prices`.`price` as `price`
                            FROM `components` 
                            JOIN `build_modules` on `components`.`build_module_id` = `build_modules`.`id` 
                            JOIN `prices` on `components`.`price_id` = `prices`.`id`
                            where `area` IS NOT NULL";
                    
                    $db->setQuery($sql);
                    $result = $db->loadAssocList();
                    
                    foreach($result as $item){
                        $c = new ComponentWithArea(
                                $item['id'],
                                $item['name'],
                                $item['area'],
                                $item['build_modules_id'],
                                $item['build_modules_name'],
                                $item['price_id'],
                                $item['price'],
                                0
                                );
                            array_push($this->componentsWithArea, $c);
                    }
                    return $this->componentsWithArea;
                    
                }

		//get all housepackages as array of objects
		function getAllHousepackages(){

			$db= JFactory::getDbo();
			$query = $db->getQuery(true);
                        
			$query->select(array('id','name', 'description', 'area', 'floors', 'img_path', 'basispreis'));
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
                                $item['img_path'],
                                $item['basispreis']
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
			$query->select(array('id','name', 'description', 'area', 'floors', 'img_path', 'basispreis'));
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
					$row->img_path,
                                        $row->basispreis
			);
			
			return $h;
		}
		
               
                    
   
		
		//get components from housepackage id
		
		
		//get Levels
		function getLevels($houseid){
			// Get a db connection.
			$db = JFactory::getDbo();
			 		
			$sql = $db->getQuery(true);
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
                
                function getComponentsAreaHouse($houseid){
                     $db= JFactory::getDbo();
                    $sql = $db->getQuery(true);
                    $sql=" select 
                            `components`.`id` as `id`, `components`.`name` as `name`, `components`.`area` as `area`, 
                            `components_combinations`.`house_package_id` as `house_package_id`,
                            `components_combinations`.`is_possible`,
                            `build_modules`.`id` as `build_modules_id`, `build_modules`.`name` as `build_modules_name`, 
                            `prices`.`id` as `price_id` ,`prices`.`price` as `price`

                            FROM `components` 

                            join `components_combinations` on `components`.`id` = `components_combinations`.`component_id`
                            join `house_packages` on `components_combinations`.`house_package_id` = `house_packages`.`id`
                            JOIN `build_modules` on `components`.`build_module_id` = `build_modules`.`id` 
                            JOIN `prices` on `components`.`price_id` = `prices`.`id`
                            where `components_combinations`.`is_possible` = 1 and `components`.`area` IS NOT NULL and `components_combinations`.`house_package_id` =".$houseid;
                                    
                    $db->setQuery($sql);
                    $result = $db->loadAssocList();
                    
                    foreach($result as $item){
                        $c = new ComponentWithArea(
                                $item['id'],
                                $item['name'],
                                $item['area'],
                                $item['build_modules_id'],
                                $item['build_modules_name'],
                                $item['price_id'],
                                $item['price'],
                                0
                                );
                            array_push($this->componentsWithArea, $c);
                    }
                    return $this->componentsWithArea;
                }
                
                function getComponentsPieceHouse($houseid){
                    $db= JFactory::getDbo();
                    $sql = $db->getQuery(true);
                    $sql=" select 
                            `components`.`id` as `id`, `components`.`name` as `name`, `components`.`area` as `area`, 
                            `components_combinations`.`house_package_id` as `house_package_id`,
                            `components_combinations`.`is_possible`,
                            `build_modules`.`id` as `build_modules_id`, `build_modules`.`name` as `build_modules_name`, 
                            `prices`.`id` as `price_id` ,`prices`.`price` as `price`

                            FROM `components` 

                            join `components_combinations` on `components`.`id` = `components_combinations`.`component_id`
                            join `house_packages` on `components_combinations`.`house_package_id` = `house_packages`.`id`
                            JOIN `build_modules` on `components`.`build_module_id` = `build_modules`.`id` 
                            JOIN `prices` on `components`.`price_id` = `prices`.`id`
                            where `components_combinations`.`is_possible` = 1 and `components`.`area` IS NULL and `components_combinations`.`house_package_id` =".$houseid;
                                    
                    $db->setQuery($sql);
                    $result = $db->loadAssocList();
                    
                    foreach($result as $item){
                        $c = new ComponentWithArea(
                                $item['id'],
                                $item['name'],
                                $item['area'],
                                $item['build_modules_id'],
                                $item['build_modules_name'],
                                $item['price_id'],
                                $item['price'],
                                0
                                );
                            array_push($this->componentsArray, $c);
                    }
                    return $this->componentsArray;
                }
                function getComponentsPiece(){
                    
                    $db= JFactory::getDbo();
                    $sql = $db->getQuery(true);
                    $sql="select 
                            `components`.`id` as `id`, `components`.`name` as `name`, `components`.`area` as `area`, 
                            `build_modules`.`id` as `build_modules_id`, `build_modules`.`name` as `build_modules_name`, 
                            `prices`.`id` as `price_id` ,`prices`.`price` as `price`
                            FROM `components` 
                            JOIN `build_modules` on `components`.`build_module_id` = `build_modules`.`id` 
                            JOIN `prices` on `components`.`price_id` = `prices`.`id`
                            where `area` IS NULL";
                    
                    $db->setQuery($sql);
                    $result = $db->loadAssocList();
                    
                    foreach($result as $item){
                        $c = new ComponentWithArea(
                                $item['id'],
                                $item['name'],
                                $item['area'],
                                $item['build_modules_id'],
                                $item['build_modules_name'],
                                $item['price_id'],
                                $item['price'],
                                0
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
		
	
    
    
 ?>

