//Main JS for House Module
var list = [];
var houseconfig = {
	
}

var levelid;



function deleteHouseconfig(elem){
    
    var $temp = jQuery(elem).closest('.bs-example-modal-sm').attr('id');
    var configid = $temp.substr($temp.indexOf("_") +1 );
    
    jQuery(elem).attr('data-dismiss', 'modal');

    
    jQuery.ajax({
		type: "POST",
		data: "housepackageid=" + configid,
		url: "?option=com_ajax&module=myHouseconfigs&method=deleteHousepackageMethod&format=json",
			success: function(data){
				jQuery.each(data, function(key, val){
                                        if(key == 'data'){
                                            var houseid = val;
                                            var div = jQuery('#' + houseid).parent('#housediv').remove();
                                            jQuery('#' + houseid).remove();
                                        }
				});       
			}
		});
}

function houseid(elem){
     //alert(jQuery(elem).closest('#housediv').find('.thumbnail').attr('id'));
     var packageid = jQuery(elem).closest('#housediv').find('.thumbnail').attr('id');
     jQuery('.bs-example-modal-sm').attr('id', 'config_'+packageid);
}


function selectLevel(elem){
    //set all buttons to green
    jQuery(elem).closest('.row').find('.button2').css("background-color", "#1f7a7a");
    //set this button to yellow
    jQuery(elem).css("background-color","#999900");
    //enable buttons for list
    jQuery(elem).closest('#site').find('.btn-primary').removeAttr('disabled');
    //get levelid for append
    levelid = jQuery(elem).attr('id');
   
}

jQuery(document).ready(function () {
	jQuery('.btn-primary').click(function(){
		var $tmppreis= jQuery(this).closest('#site').find('#basispreis').text();
                var $gesamtpreis = parseInt($tmppreis.substr($tmppreis.indexOf(": ") +1));
                
                //alert($gesamtpreis);
		jQuery(this).closest('tr').each(function(){
                        var target = jQuery(this).find('td:nth-child(1)').text();
                        var occ = 1;                  
                        jQuery.each(list, function (k, v){
                            if(v.elementname === target){
                                occ ++;
                            }
                        });
                        var preis = jQuery(this).find('td:nth-child(2)').text();
                        //alert(preis);
                        var area = jQuery(this).find('.area').val();
                        if(area == null){
                            area = "";
                        }else{
                            preis = (parseInt(preis) * parseInt(area)) + "€";
                        }
                        
			var $element = {
				elementid: jQuery(this).attr('id'),
				elementname: jQuery(this).find('td:nth-child(1)').text(),
                                elementarea: area,
				elementpreis: preis,
                                levelid: levelid
			}
			list.push($element);
			jQuery('.listcomponents').text("");
		});	
		//Get new List content and Gesamtpreis
		jQuery.each(list, function(key, val){
			$gesamtpreis += parseInt(val.elementpreis);
			jQuery('#ordergesamt').text("Gesamt: "+ $gesamtpreis);
                        //get levelid of current component
                        levelid = val.levelid;
                        jQuery('.'+levelid).after('<tr class="listcomponents" id='+ key +'><td>' + val.elementname+ '</td><td>' + val.elementpreis + '</td><td>' + val.elementarea + '</td><td><button onclick="removeRow(this);" class="btn btn-danger" >X</button></td></tr>');
		});
	});
});

function emptyList(elem){
	list.length = 0 ;
        var $temp = jQuery(elem).closest('#site').find('#basispreis').text();
	var $gesamtpreis = parseInt($temp.substr($temp.indexOf(": ") +1));
	jQuery('#ordergesamt').text("Gesamt: "+ $gesamtpreis);
	jQuery('.listcomponents').text("");
}

function removeRow(elem){
	//reset gesamtpreis
        var $temp = jQuery(elem).closest('#site').find('#basispreis').text();
	var $gesamtpreis = parseInt($temp.substr($temp.indexOf(": ") +1));
	//find row id to remove
	var trid = jQuery(elem).closest('tr').attr('id');
	//remove row
	list.splice(trid, 1);
	//empty div
	jQuery('.listcomponents').text("");
	//refill div with list elements
	jQuery.each(list, function(key, val){
		$gesamtpreis += parseInt(val.elementpreis);
			jQuery('#ordergesamt').text("Gesamt: "+ $gesamtpreis);
                        //get levelid of current component
                        levelid = val.levelid;
                        jQuery('.'+levelid).after('<tr class="listcomponents" id='+ key +'><td>' + val.elementname+ '</td><td>' + val.elementpreis + '</td><td><button onclick="removeRow(this);" class="btn btn-danger" >X</button></td></tr>');
	});
        if(jQuery(list).size() === 0){
          jQuery('#ordergesamt').text("Gesamt: "+ $gesamtpreis);  
        }
}


function saveList(elem){
	var $temp = jQuery(elem).closest('#elementlist').find('.thumbnail').attr('id');
	var $houseid = $temp.substr($temp.indexOf("_") +1 );
	var $tmp = jQuery(elem).closest('#elementlist').find('#ordergesamt').text();
	var $gesamtpreis = $tmp.substr($tmp.indexOf(": ") +1);
        var $userid = parseInt(jQuery('.userKonfig').attr('id'));
        var $name = jQuery(elem).closest('#elementlist').find('#houseconfigname').val();
        
	 
       
	//create new houseconfig object
	var houseconfig = {
                name: $name,
		houseid: $houseid,
		items: list,
		gesamtpreis: $gesamtpreis
	};
	
	//write object as JSON
	var json = JSON.stringify(houseconfig);
	var jsonArray = list;
        console.log("hallo");
        
        if($userid === 0){
            toasterDanger("Sie müssen eingeloggt sein um Ihre Hauskonfiguration zu speichern.");
            return false;
        } 
	if(jsonArray.length < 1 ){
		toasterDanger("Bitte wählen Sie Hauskomponenten aus.");
                return false;
	}
        if(jQuery(elem).closest('#elementlist').find('#houseconfigname').val().length === 0){
            toasterDanger("Bitte geben Sie einen Namen für Ihre Hauskonfiguration an.");
            return;
        }
	else{
            alert("inside else");
		jQuery.ajax({
		type: "POST",
		data: "json=" + json,
		url: "?option=com_ajax&module=houseconfiguration&method=superAwesomeMethod&format=json",
			success: function(data){
				jQuery.each(data, function(key, val){
                                        toasterSuccess("Hauskonfiguration erfolgreich gespeichert.");
				});		
			}
		});
	}
}

function toasterSuccess(message){
	var x = document.getElementById("toast");
	
	x.className = "show";
        jQuery('#toast').css("background-color","#5cb85c");
	jQuery('#toast').text(message);
	setTimeout(function(){x.className = x.className.replace("show", "");}, 5000);
}

function toasterDanger(message){
    var x = document.getElementById("toast");
    
    x.className = "show";
    jQuery('#toast').css("background-color","#ef0b26");
    jQuery('#toast').text(message);
    setTimeout(function(){x.className = x.className.replace("show", "");}, 10000);
}
