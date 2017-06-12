//Main JS for House Module
var list = [];
var houseconfig = {
	
}

var levelid;

function showComponents(id){
	jQuery.ajax({
		type: "POST",
		data: "levelid=" + id,
		url: "?option=com_ajax&module=houseconfiguration&method=getComponentsMethod&format=json",
                    success: function(result){	
                        jQuery.each(result, function(key, val){
                                if(key == 'data')
                                alert("json from php: " + val);
                        })		
                    }
	});
}


function test(){
	alert("hallo");
}

function selectLevel(elem){
    //set all buttons to green
    jQuery(elem).closest('.caption').find('.button2').css("background-color", "#1f7a7a");
    //set this button to yellow
    jQuery(elem).css("background-color","#999900");
    //enable buttons for list
    jQuery(elem).closest('.thumbnail').find('.btn-primary').removeAttr('disabled');
    //get levelid for append
    levelid = jQuery(elem).attr('id');
}

jQuery(document).ready(function () {
	jQuery('.btn-primary').click(function(){
		var $gesamtpreis= 0;
		jQuery(this).closest('tr').each(function(){
                        var target = jQuery(this).find('td:nth-child(1)').text();
                        var occ = 1;                  
                        jQuery.each(list, function (k, v){
                            if(v.elementname === target){
                                occ ++;
                            }
                        });
			var $element = {
				elementid: jQuery(this).attr('id'),
				elementname: jQuery(this).find('td:nth-child(1)').text(),
				elementpreis: jQuery(this).find('td:nth-child(2)').text(),
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
                        jQuery('.'+levelid).after('<tr class="listcomponents" id='+ key +'><td>' + val.elementname+ '</td><td>' + val.elementpreis + '</td><td><button onclick="removeRow(this);" class="btn btn-danger" >X</button></td></tr>');
		});
	});
});

function emptyList(){
	list.length = 0 ;
	jQuery('#ordergesamt').text("Gesamt: 0");
	jQuery('.listcomponents').text("");
}

function removeRow(elem){
	//reset gesamtpreis
	var $gesamtpreis = 0;
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
	
	//create new houseconfig object
	var houseconfig = {
		houseid: $houseid,
		items: list,
		gesamtpreis: $gesamtpreis
	};
	
	//write object as JSON
	var json = JSON.stringify(houseconfig);
	
	var jsonArray = list;
	if(jsonArray.length < 1 ){
		alert("there must be stuff in list");
	}
	else{
		jQuery.ajax({
		type: "POST",
		data: "json=" + json,
		url: "?option=com_ajax&module=house&method=superAwesomeMethod&format=json",
			success: function(result){	
				//alert("json from php: "+result);
				jQuery.each(result, function(key, val){
					if(key == 'data')
					alert("json from php: " + val);
				})
				//success toast
				toaster();		
			}
		});
	}
}

function toaster(){
	var x = document.getElementById("toast");
	
	x.className = "show";
	
	setTimeout(function(){x.className = x.className.replace("show", "");}, 3000);
}
