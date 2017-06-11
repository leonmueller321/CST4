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
	
	$db = new Database();
	$item = $db->getHousepackage($_GET['choosePackage']);	
	$levels = $db->getLevels($houseid);
        $components = $db->getComponents();
        $buildModules = $db->getAllBuildModules();
        $prices = $db->getAllPrices();
        $comp_prices = array();
        
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
                        echo "<button class='button button2' onclick='selectLevel(this);' id='level_$level->id'>$level->name</button>";
                    };
                    
                    echo "<table class='table' id='component_table'>"; 
                    foreach($buildModules as $b){
                        echo "<tr id='baugruppe_$b->id' style='background-color: #20b2aa; color: white;'>";
			echo "<th>$b->name</th><th></th><th></th></tr>";
                            foreach($comp_prices as $c){     
                                if($c->build_module_id == $b->id){
                                    echo "<tr id='komponenten_$c->id' class='nr'><td>";
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
	
		echo "<div id='elementlist' class='col-sm-4 col-md-4'>";
		echo "<div class='thumbnail' id='elementlist_".$houseid."'>";
?>
                <div class='caption'>
                <h4>Gewählte Komponenten</h4>
                        <table class='table table-hover' id='elementorder'>

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

