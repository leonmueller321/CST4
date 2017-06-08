<?php
class Element{
	
	public $elementid;
	public $name;
	public $preis;
	
	function __construct($id,$name, $preis){
		$this->elementid = $id;
		$this->name = $name;
		$this->preis = $preis;
	}
}

?>