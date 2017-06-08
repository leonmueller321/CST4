<?php
	
	//JQUERY
	$doc = JFactory::getDocument();
	JHtml::_('jquery.framework');
	
	// get parameter from chosen package
	$houseid = $_GET['choosePackage'];

	$db = new Database();
	$row = $db->getHousepackage($_GET['choosePackage']);
	$allElements = $db->getAllElements();
	//$chosenElements = array();
	$gesamtPreis=0;
	
	/*
	if(isset($_GET['toList'])){
		
		$e = $db->getElement($_GET['toList']);
		array_push($chosenElements, $e);
		
		//collect elementids in Session
		array_push($_SESSION['elementlist'], $_GET['toList']);	
		//push elementids as objects in another array
		foreach($_SESSION['elementlist'] as $elementForList){
			$e = $db->getElement($elementForList);
			array_push($chosenElements, $e);
		}
		
	}
	

	if(isset($_GET['deleteThisItem'])){
			$temp_arr = array_diff($_SESSION['elementlist'], array($_GET['deleteThisItem']));
			$_SESSION['elementlist'] = $temp_arr;
			var_dump($_SESSION['elementlist']);
	}

	
	//ElementList
	//check if session exists or elementlist should be empty
	if(!isset($_SESSION['elementlist']) || isset($_GET['deleteElementlist'])){
		$_SESSION['elementlist'] = array();
	}
	
	//emptylist isset -> empty all arrays
	if(isset($_GET['emptyList'])){
		$_SESSION['elementlist'] = array();
		$chosenElements = array();
	}
	*/
	
	echo "<h3>Hauskonfiguration</h3>";
	echo "<div class='row'>";
	
	//first div for chosen housepackage
	//echo the house information
	echo "<div id='housediv' class='col-sm-4 col-md-4'>";
		echo "<div class='thumbnail'> <img src='' alt=''>";
			echo "<div class='caption'>";
			echo "<h3 >$row->name</h3></br>";
			echo "<p>$row->description</p>";
	echo "</div></div></div>";
	
	$houseid = $row->houseid;

	//Element Thumbnail
	echo "<div class='col-sm-4 col-md-4'>";
		echo "<div class='thumbnail'>";
			echo "<div class='caption'>";
			echo "<h4>Choose Configurations</h4>";
			
			echo "<table class='table table-hover'>";
			echo "<tr>";
			echo "<th>Name</th><th>Preis</th><th></th></tr>";
			foreach($allElements as $element){
					echo "<tr class='nr'><td>";
					//echo "<input type='hidden' id='elementid' name='$element->elementid'/>";
					echo $element->name;
					//echo "<input type='hidden' id='elementname' name='$element->name'/>";
					echo "</td><td>";
					echo $element->preis."€";
					//echo "<input type='hidden' id='elementpreis' name='$element->preis'/>";
					echo "</td><td>";
					//onclick arraypush element
					//echo "<a href='hauspakete?choosePackage=$houseid&toList=$element->elementid'><button id='$element->elementid' class='btn btn-primary'>Add</button></a>";
					echo "<button type='button' name='addElement' id='$element->elementid' class='btn btn-primary'>Add</button>";
					echo "</td></tr>";
			}
			echo "</table>";
			echo "</div></div></div>";
	
	echo "<div id='elementlist' class='col-sm-4 col-md-4'>";
		echo "<div class='thumbnail'>";
			echo "<div class='caption'>";
			echo "<h4>Chosen Elements</h4>";
			
			echo "<table class='table table-hover' id='elementorder'>";
			echo "<tr><th>Name</th><th>Preis</th><th></th></tr>";
			foreach($chosenElements as $key=>$element){
				echo "<tr><td>";
				echo $element->name;
				echo "</td><td>";
				echo $element->preis;
				echo "</td><td>";
				echo "<a href='hauspakete?choosePackage=$houseid&deleteThisItem=$element->elementid'><button class='btn btn-danger'> X</button></a>";
				echo "</td></tr>";
				$gesamtPreis += $element->preis;
			}
			echo "</table>";			
			echo "<div class='alert alert-success' role='alert'>Gesamtpreis: $gesamtPreis</div>";
			echo "<a href=hauspakete?choosePackage=$houseid&emptyList=1'><button class='btn btn-danger'>Delete All</button></a>";
			//echo "<span class='label label-success'>Gesamtpreis: $gesamtPreis</span>";
			//echo "<p>Gesamtpreis: $gesamtPreis</p>";
			
	echo "</div></div></div>";

	
	//end of row div
	echo "</div>";

	?>
	<div class="row">
		<div class='col-sm-4 col-md-4' >
		<table class='table table-hover' id='elementorder'>
			<tr><th>Name</th><th>Preis</th></tr>
		</table>
		</div>
	
	
		<div class='col-sm-4 col-md-4'>
			<div class="btn-group btn-group-justified" role="group" aria-label="...">
			  
			  <div class="btn-group" role="group">
				<button type="button" class="btn btn-danger">Cancel</button>
			  </div>
			  <div class="btn-group" role="group">
				<button type="button" id='myButton' class="btn btn-success">Load List</button>
			  </div>
			</div>
		</div>
	</div>
