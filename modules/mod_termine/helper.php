<?php

defined('_JEXEC') or die;
	
        include('model/termin.class.php');
        
	class Database{
		
            private $db;
            
            
            function insertTermin($date, $vn, $nn, $uid, $b, $n){
                $t = new Termin($date, $vn, $nn, 0, $uid, "noch nicht bearbeitet");

                //connect to db
                    $db = JFactory::getDbo();
                    $query = $db->getQuery(true);
                    
                    $result = JFactory::getDbo()->insertObject('appointments', $t);
            }
             
        }
    
 ?>

