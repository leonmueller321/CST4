<?php

defined('_JEXEC') or die;
	
        //JQUERY
	$doc = JFactory::getDocument();
	JHtml::_('jquery.framework');	
        
        $url = Juri::base() . 'templates/osprealestate/css/toast.css';
        $url2 = Juri::base() . 'templates/osprealestate/css/liststyle.css';
	$js = Juri::base() . 'templates/osprealestate/js/main.js';
        $style = Juri::base() . 'modules/mod_myHouseconfigs/css/houseconfigsStyle.css';

	$doc->addStyleSheet($url);
        $doc->addStyleSheet($url2);
	$doc->addScript($js);
        $doc->addStyleSheet($style);
        
        $user = JFactory::getUser();
        $userid = $user->id;
        
	$db = new Database();
	$myHouses = $db->getHouses($userid);
        $housePackageArray = array();
        $tmpHP = array();
       
	//get root image path
	$img =  JURI::root().'images/houses/';
        echo "<p>Hello {$user->name}, your email is {$user->email} ID is {$user->id}</p>";

        
	echo "<h3>Meine Hauskonfigurationen</h3>";
	echo "<h4>Wähle eine Hauskonfiguration um diese zu bearbeiten</h4>";
	
	echo "<div class='row'>";
	//output in thumbnails
	foreach($myHouses as $h){
            echo "<div id='housediv' class='col-sm-6 col-md-4'>";
                echo "<div id='$h->id' class='thumbnail'> <img style='width:100%; height:180px;' src='$img";
                echo "$h->img_path' alt=''>";
                    echo "<div class='caption'>"; 
                        echo "<h3 >$h->name</h3>";
                        echo "<h5>Details:</h5>";
                        echo "<p>Gesamtpreis: $h->gesamtpreis</p>";
                        echo "<div class='btn-group btn-group-justified' role='group' aria-label='...'>";
                            echo "<div class='btn-group' role='group'>";
                                echo "<button type='button' class='btn btn-danger' onclick='houseid(this);' data-toggle='modal' data-target='.bs-example-modal-sm'>Löschen</button>";
                            echo "</div>";
                            echo "<div class='btn-group' role='group'>";
                                echo "<button type='button' onclick='' class='btn btn-success'><a href='meine-hauskonfigurationen?choosePackage=$h->house_package_id' class='bearbeiten'>Bearbeiten</a></button>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                echo "</div>";
                    
            echo "</div>";
            
	}
	
	echo "</div>";	
?>

<!-- Modal for delete -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Löschen bestätigen</h4>
      </div>
      <div class="modal-body">
        <p>Wollen Sie diese Hauskonfiguration wirklich löschen?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="deleteHouseconfig(this);">Löschen</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->