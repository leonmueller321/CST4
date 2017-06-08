
<?php
	defined('_JEXEC') or die;
	//include ('helper.php');
	
	$db = new Database();
	$houseArray = $db->getAllHousepackages();
    
	
	//Get Current User
    $user = JFactory::getUser();
    echo "<p>Hello {$user->name}, your email is {$user->email} ID is {$user->id}</p>";

	echo "<h3>Hauspaket wählen</h3>";
	echo "<h4>Wähle ein Hauspaket um die Hauskonfiguration zu starten.</h4>";
	
	
	echo "<div class='row'>";
	
	//output in thumbnails
	foreach($houseArray as $item){
		echo "<div id='housediv' class='col-sm-6 col-md-4'>";

		echo "<div class='thumbnail'> <img src='' alt=''><div class='caption'>";
		echo "<h3 >$item->name</h3></br>";
		echo "<p>$item->description</p>";
		
		//link muss immer aktualisiert werden bei ftp push
		echo "<p><a href='houseconfiguration?choosePackage=$item->houseid' role='button' class='btn btn-primary'>Auswählen</a></p></div></div></div>";

	}
	
	echo "</div>";
	
	
?>

<button onClick="help();">click</button>



