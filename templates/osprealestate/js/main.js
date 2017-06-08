
var list = [];
var houseconfig = {
	
}

jQuery(document).ready(function () {
	jQuery('.btn-primary').click(function(){
		var $gesamtpreis= 0;
		jQuery(this).closest('tr').each(function(){
			var $element = {
				elementid: jQuery(this).attr('id'),
				elementname: jQuery(this).find('td:nth-child(1)').text(),
				elementpreis: jQuery(this).find('td:nth-child(2)').text()
			}
			list.push($element);
			jQuery('#elementorder').text("");
		});	
		//Get new List content and Gesamtpreis
		jQuery.each(list, function(key, val){
			$gesamtpreis += parseInt(val.elementpreis);
			jQuery('#ordergesamt').text("Gesamt: "+ $gesamtpreis);
			jQuery('#elementorder').append('<tr id='+ key +'><td>' + val.elementname+ '</td><td>' + val.elementpreis + '</td><td><button onclick="removeRow(this);" class="btn btn-danger" >X</button></td></tr>');
		});
	});
});

function emptyList(){
	list.length = 0 ;
	jQuery('#ordergesamt').text("Gesamt: 0");
	jQuery('#elementorder').text("");
}

function removeRow(elem){
	//reset gesamtpreis
	var $gesamtpreis = 0;
	//find row id to remove
	var trid = jQuery(elem).closest('tr').attr('id');
	//remove row
	list.splice(trid, 1);
	//empty div
	jQuery('#elementorder').text("");
	//refill div with list elements
	jQuery.each(list, function(key, val){
		$gesamtpreis += parseInt(val.elementpreis);
		jQuery('#ordergesamt').text("Gesamt: "+ $gesamtpreis);
		jQuery('#elementorder').append('<tr id='+ key +'><td>' + val.elementname+ '</td><td>' + val.elementpreis + '</td><td><button onclick="removeRow(this);" class="btn btn-danger" >X</button></td></tr>');
	});
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
