<?php
	
	//JQUERY
	$doc = JFactory::getDocument();
	JHtml::_('jquery.framework');	
        
	$url = Juri::base() . 'templates/osprealestate/css/toast.css';
        $url2 = Juri::base() . 'templates/osprealestate/css/liststyle.css';
	$doc->addStyleSheet($url);
        $doc->addStyleSheet($url2);
        
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

	echo "<div class='row'>";
                echo "<div id='image' class='col-sm-6 col-md-4'>";
                    echo "<img style='width:100%; height:200px;' src='$img";
                    echo "$item->img_path' alt=''>";
                echo "</div>";
                echo "<div id='details' class='col-sm-6 col-md-4'>";
                    echo "<h3 >$item->name</h3>";
                    echo "<p>$item->description</p>";
                    echo "<h5>Details:</h5>";
                    echo "<p>Grundfläche: $item->area m²</p>";
                    echo "<p>Etagen: $item->floors</p>";
                echo "</div>";
        echo "</div>";
        echo "</br>";

        
        echo "<div class='row'>";
	//Component Thumbnail
	echo "<div class='col-sm-4 col-md-6'>";
            echo "<div class='thumbnail'>";
                echo "<div class='caption'>";
                    echo "<h4 style='float:left; margin-right:50px;'>Hauskomponenten</h4>";
                    foreach($levels as $level){
                        echo "<button class='button button2'>$level->name</button>";
                    };
                    
                    foreach($buildModules as $b){
                        echo"<ul style='clear:both; margin-top:10px;' class='list list--material'>
                            <li style='font-size: 18px; background-color: #20b2aa; color: white;' class='list__header'>$b->name</li>";
                            foreach($components as $c){
                                 if($c->build_module_id == $b->id){
                                     echo "<li class='list__item list__item--material'>
                                            <div class='list__item__left list__item--material__left'>
                                              <div class='list__item__title list__item--material__title'>$c->name</div>
                                            </div>

                                            <div class='list__item__right list__item--material__right'>
                                              <button class='fab fab--mini'><i class='glyphicon glyphicon-plus'></i></button>
                                            </div>
                                          </li>";
                                 }
                            }
                        echo "</ul>";
                    };

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
                        </div>
	</div><!-- end of row div -->

	<div class="row">
		<div class='col-sm-4 col-md-4' id="testdiv">
		</div>
	

	</div>
	
	<div id="toast">Hauskonfiguration erfolgreich gespeichert.</div>

