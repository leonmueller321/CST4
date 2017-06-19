<?php

defined('_JEXEC') or die;
	
        include('model/termin.class.php');
        
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
        
	class Database{
		
            private $db;
            
            
            
        
        
            function insertTermin($date, $vn, $nn, $uid, $b, $n){
                $t = new Termin($date, $vn, $nn, 0, $uid, "noch nicht bearbeitet");

                //connect to db
                    $db = JFactory::getDbo();
                    $query = $db->getQuery(true);
                    $result = JFactory::getDbo()->insertObject('appointments', $t);
                    
                    $sql = $db->getQuery(true);
                    $sql= "SELECT MAX(id)
                            FROM `appointments`";
                    $db->setQuery($sql);
                    $result = $db->loadResult();
                    
                    $rowid = $result;
                    
                    $id = getGUID();
                    //insert into houses
                    $test2 = new stdClass();
                    $test2->id = $id;
                    $test2->tablename = "appointments";
                    $test2->rowid = $rowid;
                    $test2->operation = "insert";
                    $result2 = JFactory::getDbo()->insertObject('change_log', $test2);
            }
             
        }
    
 ?>

