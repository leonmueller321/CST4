<?php

defined('_JEXEC') or die;
	
	$db = new Database();
	$houseArray = $db->getAllHousepackages();
	//get root image path
	$img =  JURI::root().'images/houses/';
	//Get Current User
    //$user = JFactory::getUser();
    //echo "<p>Hello {$user->name}, your email is {$user->email} ID is {$user->id}</p>";

	echo "<h3>Hauspaket wählen</h3>";
	echo "<h4>Wähle ein Hauspaket um die Hauskonfiguration zu starten.</h4>";
	
	echo "<div class='row'>";
	
	//output in thumbnails
	foreach($houseArray as $item){
		
		echo "<div id='housediv' class='col-sm-6 col-md-4'>";
		echo "<div class='thumbnail'> <img style='width:100%; height:180px;' src='$img";
		echo "$item->img_path' alt=''><div class='caption'>";
		echo "<h3 >$item->name</h3>";
		echo "<p>$item->description</p>";
		echo "<h5>Details:</h5>";
		echo "<p>Grundfläche: $item->area m²</p>";
		echo "<p>Etagen: $item->floors</p>";
		
		echo "<p><a href='houseconfiguration?choosePackage=$item->id' role='button' class='btn btn-primary'>Auswählen</a></p></div></div></div>";

	}
	
	echo "</div>";
	
	
?>