<?php
	//JQUERY
	$doc = JFactory::getDocument();
	JHtml::_('jquery.framework');	

        include('model/comp_price.class.php');
        
	$url = Juri::base() . 'templates/osprealestate/css/toast.css';
        $url2 = Juri::base() . 'templates/osprealestate/css/liststyle.css';
	$js = Juri::base() . 'templates/osprealestate/js/main.js';
	$doc->addStyleSheet($url);
        $doc->addStyleSheet($url2);
	$doc->addScript($js);
        
	// get parameter from chosen package
	$houseid = $_GET['choosePackage'];
	//get root image path
	$img =  JURI::root().'images/houses/';
        $user = JFactory::getUser();
	
	$db = new Database();
	$item = $db->getHousepackage($_GET['choosePackage']);	
	$levels = $db->getLevels($houseid);
        $components = $db->getComponents();
        $buildModules = $db->getAllBuildModules();
        $prices = $db->getAllPrices();
        $comp_prices = array();
        $cnt = 0;
        $compWithArea = $db->getComponentsWithArea();
        
        //var_dump($compWithArea);
        //array to get build modules from componentsWithArea
        $tmpBuild = array();
        
        
        //create component array with prices
        foreach ($prices as $p) {
            foreach($components as $c){
                if($p->id == $c->price_id){
                    $cp = new CompPrice(
                         $c->id,
                         $c->name,
                         $p->price,
                         $p->id,
                         $c->build_module_id
                     );
                    array_push($comp_prices, $cp);
                }
            }
        }
     
	foreach($levels as $lev){
           $cnt++; 
        }
	echo "<h3 class='userKonfig' id='$user->id'>Hauskonfiguration</h3>";
	echo "<div class='row' id='site'>";
	
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
                    echo "<p id='basispreis'>Basispreis: $item->basispreis</p>";
                    echo "<p>Etagen: $cnt</p>";
                echo "</div>";
        echo "</div>";
        echo "</br>";
        
        echo "<div class='row'>";
            echo "<div id='image' class='col-sm-6 col-md-4'>";
                echo "<h4>Bitte wählen Sie eine Etage aus:</h4>";
                foreach($levels as $level){
                        echo "<button class='button button2' onclick='selectLevel(this);' id='level_$level->id'>$level->name</button>";
                }; 
            echo "</div>";
        echo "</div>";
        echo "</br>";
        
        echo "<div class='row'>";
	//Components per Piece Thumbnail
	echo "<div class='col-sm-4 col-md-4'>";
            echo "<div class='thumbnail' id='compPerPiece'>";
                echo "<div class='caption'>";
                    echo "<h4 margin-right:50px;'>Stückkomponenten</h4>";

                    echo "<table class='table' id='component_table'>"; 
                    foreach($buildModules as $b){
                        echo "<tr id='baugruppe_$b->id' style='background-color: #20b2aa; color: white;'>";
			echo "<th>$b->name</th><th>Preis</th><th></th></tr>";
                            foreach($comp_prices as $c){     
                                if($c->build_module_id == $b->id){
                                    echo "<tr id='komponenten_per_piece_$c->id' class='nr'><td>";
                                    echo $c->name;
                                    echo "</td><td>";
                                    echo $c->preis . "€";
                                    echo "</td><td>";
                                    //onclick arraypush element
                                    echo "<button disabled='disabled' class='btn btn-primary' style='border-radius: 50%; background-color:  #1f7a7a; box-shadow: 0 4px 5px 0 rgba(0,0,0,0.14), 0 1px 10px 0 rgba(0,0,0,0.12), 0 2px 4px -1px rgba(0,0,0,0.4);'"
                                    . "><i class='glyphicon glyphicon-plus' id='$c->id'></button>";
                                    echo "</td></tr>";
                                }
                            }
                    }
                echo "</table>";
                 

	echo "</div></div></div>";
        
    //Start of Components with area Div
        echo "<div class='col-sm-4 col-md-4'>";
            echo "<div class='thumbnail' id='compWithArea'>";
                echo "<div class='caption'>";
                    echo "<h4 margin-right:50px;'>Flächenkomponenten</h4>";
                             
                    echo "<table class='table' id='componentWithArea_table'>"; 
                    foreach($buildModulesArea as $b){
                        echo "<tr id='baugruppe_$b' style='background-color: #20b2aa; color: white;'>";
                        echo "<th>$b</th><th>Preis/m²</th><th>m²</th><th></th></tr>";
                        foreach($compWithArea as $c){
                            if($c->build_modules_name == $b){
                                 echo "<tr id='komponenten_with_area_$c->id' class='nr'><td>";
                                    echo $c->name;
                                    echo "</td><td>";
                                    echo $c->price . "€";
                                    echo "</td><td>";
                                    echo "<input type='number' class='area' name='area' min='1' max='500'>";
                                    echo "</td><td>";
                                    //onclick arraypush element
                                    echo "<button disabled='disabled' class='btn btn-primary' style='border-radius: 50%; background-color:  #1f7a7a; box-shadow: 0 4px 5px 0 rgba(0,0,0,0.14), 0 1px 10px 0 rgba(0,0,0,0.12), 0 2px 4px -1px rgba(0,0,0,0.4);'"
                                    . "><i class='glyphicon glyphicon-plus' id='$c->id'></button>";
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
                        <p style="float:left; margin-right: 10px">Name:</p><input style="margin-bottom: 10px;" type="text" id="houseconfigname" required>
                        <table style="clear:both;" class='table table-hover' id='elementorder'>
                            <?php
                            foreach($levels as $level){
                                echo "<tr class='level_$level->id'><th>$level->name</th><th>Preis</th><th>m²</th><th></th></tr>";
                            }
                            ?>
                                <!-- Elements loaded via JS -->
                        </table>			
                <div id='ordergesamt' class='alert alert-success' role='alert'>Gesamt: </div>
                    <div class="btn-group btn-group-justified" role="group" aria-label="...">

                      <div class="btn-group" role="group">
                            <button type="button" onclick='emptyList(this);' class="btn btn-danger">Delete All</button>
                      </div>
                      <div class="btn-group" role="group">
                            <button type="button" onclick='saveList(this);' class="btn btn-success">Save</button>
                      </div>
                    </div>
                    </br>
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

