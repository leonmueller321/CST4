<?php
	//JQUERY
	$doc = JFactory::getDocument();
	JHtml::_('jquery.framework');	

        //include('model/componentWithArea.class.php');
        
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
        
        $user = JFactory::getUser();
        $username = $user->name;

        $houseconfig = $db->getHouseConfig($houseid);
        $housepackageID = $houseconfig->house_package_id;
	$levels = $db->getLevels($housepackageID);
        
        $components = $db->getComponentsPieceHouse($housepackageID);
        $compWithArea = $db->getComponentsAreaHouse($housepackageID);
        $build = $db->getAllBuildModules();
        
        $tmpBuild = array();
        $tmpBuildPiece = array();
        foreach($compWithArea as $c){
            array_push($tmpBuild, $c->build_modules_name);     
        }
        $buildModulesArea = array_unique($tmpBuild);
        
        foreach($components as $c){
            array_push($tmpBuildPiece, $c->build_modules_name);     
        }
        $buildModules = array_unique($tmpBuildPiece);
        
        $items = json_decode($houseconfig->items, true);
        $elementarray = array();
        
        foreach($items as $item){
            $bname = $db->getBuildModuleName($item['buildmoduleid']); 
            $levelid = $item['levelid'];
            $level = $levelid[6];
            
            if(strlen($levelid) > 7){
                //echo strlen($levelid) . "</br>";
                $level = $level . $levelid[7];
            }
            
            $e = new ComponentWithArea(
                    $item['elementid'],
                    $item['elementname'],
                    $item['elementarea'],
                    $item['buildmoduleid'],
                    $bname,
                    $item['preisid'],
                    $item['elementpreis'],
                    $level
                    );
            array_push($elementarray, $e);
        }
     

	echo "<h3 class='userKonfig' id='$user->id'>Hauskonfiguration</h3>";
	echo "<div class='row' id='site'>";
	
	//first div for chosen housepackage
	//echo the house information

	echo "<div class='row'>";
                echo "<div id='image' class='col-sm-6 col-md-4'>";
                    echo "<img style='width:100%; height:200px;' src='$img";
                    echo "$houseconfig->img_path' alt=''>";
                echo "</div>";
                echo "<div id='details' class='col-sm-6 col-md-4'>";
                    echo "<h3 >$houseconfig->name</h3>";
                    echo "<h5>Details:</h5>";
                    echo "<p id='basispreis'>Preis: $houseconfig->gesamtpreis</p>";
                    echo "<p>Kunde: $username</p>";
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
                        echo "<tr id='baugruppe_$b' style='background-color: #20b2aa; color: white;'>";
			echo "<th>$b</th><th>Preis</th><th></th></tr>";
                            foreach($components as $c){     
                                if($c->build_modules_name == $b){
                                    echo "<tr id='komponenten_$c->id:$c->build_modules_id/$c->price_id' class='nr'><td>";
                                    echo $c->name;
                                    echo "</td><td>";
                                    echo $c->price . "€";
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
                                 echo "<tr id='komponenten_$c->id:$c->build_modules_id/$c->price_id' class='nr'><td>";
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

                echo "<div id='$houseconfig->id' class='caption'>";
 ?>
                <h4>Gewählte Komponenten</h4>
                        <p style='float:left; margin-right: 10px'>Name:</p>
                        <input style='margin-bottom: 10px;' type='text' id='houseconfigname' 
                           placeholder=" <?php echo $houseconfig->name; ?>"
                        >
                        <table style='clear:both;' class='table table-hover' id='elementorder'>
                        <?php
                            foreach($levels as $level){
                                echo "<tr class='level_$level->id'><th>$level->name</th><th>Preis</th><th>m²</th><th></th></tr>";
                            }
                        ?>
                              
                        </table>			
                
                    <div id='ordergesamt' class='alert alert-success' role='alert'>Gesamt: <?php echo $houseconfig->gesamtpreis; ?></div>
                    <div class='btn-group btn-group-justified' role='group' aria-label='...'>

                      <div class='btn-group' role='group'>
                            <button type='button' onclick='emptyList(this);' class='btn btn-danger'>Delete All</button>
                      </div>
                      <div class='btn-group' role='group'>
                            <button type='button' onclick='updateList(this);' class='btn btn-success'>Save</button>
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
        
        <?php
        
        echo "<table style='' class='config'>";
        echo "<th>id</th><th>name</th><th>area</th><th>price</th><th>priceid</th><th>bmid</th><th>bname</th><th>levelid</th>";
        foreach($elementarray as $elem){
            echo "<tr class='elemento'><td class='elementid'>";
            echo $elem->id;
            echo"</td><td class='name'>";
            echo $elem->name;
            echo"</td><td class='area'>";
            echo $elem->area;
            echo"</td><td class='preis'>";
            echo $elem->price;
            echo"</td><td class='preisid'>";
            echo $elem->price_id;
            echo"</td><td class='build_module_id'>";
            echo $elem->build_modules_id;
            echo"</td><td class='build_name'>";
            echo $elem->build_modules_name;
            echo"</td><td class='levelid'>";
            echo $elem->levelid;
            echo "</td></tr>";
        }
        echo "</table>";
        
        

