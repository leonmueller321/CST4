<?php

defined('_JEXEC') or die;

//JQUERY
	$doc = JFactory::getDocument();
	JHtml::_('jquery.framework');	

        
	$url = Juri::base() . 'templates/osprealestate/css/toast.css';
        $url2 = Juri::base() . 'templates/osprealestate/css/liststyle.css';
	$js = Juri::base() . 'templates/osprealestate/js/main.js';
        $datepicker = Juri::base() . 'datepicker/js/bootstrap-datepicker.js';
        $datepicker2 = Juri::base() . 'datepicker/js/bootstrap-datepicker.min.js';
        $datepickerstyle = Juri::base() . 'datepicker/css/bootstrap-datepicker.css';
        
	$doc->addStyleSheet($url);
        $doc->addStyleSheet($url2);
        $doc->addStyleSheet($datepickerstyle);
	$doc->addScript($js);
        $doc->addScript($datepicker);
        $doc->addScript($datepicker2);
        
//default page
?>
<form class="form-horizontal" action="#" method="POST">
  <div class="form-group">
    <label for="nachname" class="col-sm-2 control-label">Nachname</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputPassword3" name="nachname" placeholder="Nachname">
    </div>
  </div>
  <div class="form-group">
    <label for="vorname" class="col-sm-2 control-label">Vorname</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputPassword3" name="vorname" placeholder="Vorname">
    </div>
  </div>
  <div class="form-group">
    <label for="date" class="col-sm-2 control-label">Datum</label>
    <div class="col-sm-10">
    <div class="input-group date" data-provide="datepicker">
       <input type="text" name="date" class="form-control" placeholder="Datum auswählen">
            <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
            </div>
     </div>
    </div>
  </div> 
  <div class="form-group">
    <label for="uhrzeit" class="col-sm-2 control-label">Uhrzeit</label>
    <div class="col-sm-10">
      <input type="time" name="uhrzeit" placeholder="23:00">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" name="submit" class="btn btn-default">Abschicken</button>
    </div>
  </div>
</form>