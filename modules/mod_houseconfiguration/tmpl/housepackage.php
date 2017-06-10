<?php
	
	//JQUERY
	$doc = JFactory::getDocument();
	JHtml::_('jquery.framework');	
        
	
	// get parameter from chosen package
	$houseid = $_GET['choosePackage'];
	//get root image path
	$img =  JURI::root().'images/houses/';
	
	$db = new Database();
	$item = $db->getHousepackage($_GET['choosePackage']);	
	$levels = $db->getLevels($houseid);
        $components = $db->getComponents();
        $buildModules = $db->getAllBuildModules();
        
	
	echo "<h3>Hauskonfiguration</h3>";
	echo "<div class='row'>";
	
	//first div for chosen housepackage
	//echo the house information
	echo "<div id='housediv' class='col-sm-6 col-md-4'>";
		echo "<div class='thumbnail'> <img style='width:100%; height:180px;' src='$img";
		echo "$item->img_path' alt=''><div class='caption'>";
		echo "<h3 >$item->name</h3>";
		echo "<p>$item->description</p>";
		echo "<h5>Details:</h5>";
		echo "<p>Grundfläche: $item->area m²</p>";
		echo "<p>Etagen: $item->floors</p>";
	echo "</div></div></div>";
	
	$houseid = $row->houseid;

	
	//Component Thumbnail
	echo "<div class='col-sm-4 col-md-4'>";
            echo "<div class='thumbnail'>";
                echo "<div class='caption'>";
                
                echo "<h4 style='float:left; margin-right:50px;'>Hauskomponenten</h4>";
                echo "<div class='dropdown'>
                    <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenu2' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            Etagen<span class='caret'></span>
                    </button>
                    <ul class='dropdown-menu' aria-labelledby='dropdownMenu2'>";
                    foreach($levels as $level){
                        echo "<li class='levels' id='$level->id' ><a onclick='showComponents($level->id);'>$level->name</a></li>";
                    }
                    echo "</ul></div>";
                    //Level Components
                    echo "<table class='table'>";
                        foreach($buildModules as $m){
                            echo "<tr><th class='thComponents'>".$m->name."</th><th class='thComponents'></th></tr>";
                            foreach($components as $c){
                                if($c->build_module_id == $m->id){
                                    echo "<tr><td>";
                                    //echo $c->id;
                                    //echo "</td><td>";
                                    echo $c->name;
                                    echo "</td><td>";
                                    echo "<button type='button' name='addElement' class='btn btn-primary'>Add</button>";
                                    echo "</td></tr>";
                                } 
                            }
                        }
                    echo "</table>";
	echo "</div></div></div>";
	
		echo "<div id='elementlist' class='col-sm-4 col-md-4'>";
		echo "<div class='thumbnail' id='elementlist_".$houseid."'>";
?>
				<div class='caption'>
				<h4>Gewählte Komponenten</h4>
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
