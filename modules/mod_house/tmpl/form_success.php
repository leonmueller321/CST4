<?php
	
	//JQUERY
	$doc = JFactory::getDocument();
	JHtml::_('jquery.framework');	
	
	// get parameter from chosen package
	$houseid = $_GET['choosePackage'];
	
	$db = new Database();
	$row = $db->getHousepackage($_GET['choosePackage']);
	$allElements = $db->getAllElements();	
	
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
					echo "<tr id='$element->elementid' class='nr'><td>";
					echo $element->name;
					echo "</td><td>";
					echo $element->preis."€";
					echo "</td><td>";
					//onclick arraypush element
					echo "<button type='button' name='addElement' id='$element->elementid' class='btn btn-primary'>Add</button>";
					echo "</td></tr>";
			}
			echo "</table>";
			echo "</div></div></div>";
	
		echo "<div id='elementlist' class='col-sm-4 col-md-4'>";
		echo "<div class='thumbnail' id='elementlist_".$houseid."'>";
?>
				<div class='caption'>
				<h4>Chosen Elements</h4>
					<table class='table table-hover' id='elementorder'>
						<tr><th>Name</th><th>Preis</th><th></th></tr>
						<!-- Elements loaded via JS -->
					</table>			
				<div id='ordergesamt' class='alert alert-success' role='alert'>Gesamt: </div>
					<div class="btn-group btn-group-justified" role="group" aria-label="...">
				  
					  <div class="btn-group" role="group">
						<button type="button" onclick='emptyList();' class="btn btn-danger">Delete All</button>
					  </div>
					  <div class="btn-group" role="group">
						<button type="button" onclick='saveList(this);' class="btn btn-success">Save</button>
					  </div>
					</div>
					</br>
					<div class="alert alert-danger" role="alert">
						Sie müssen sich
					  <a href="#" class="alert-link">einloggen</a>
						um Ihre Hauskonfiguration zu speichern.
					</div>
				</div>
			</div>
		</div>
	</div><!-- end of row div -->

	<div class="row">
		<div class='col-sm-4 col-md-4' id="testdiv">
		</div>
	

	</div>
	
	<div id="toast">Hauskonfiguration erfolgreich gespeichert.</div>
