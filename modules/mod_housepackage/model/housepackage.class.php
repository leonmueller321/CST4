<?php

class Housepackage{
	
	public $houseid;
	public $name;
	public $description;
	
	function __construct($id,$name, $desc){
		$this->houseid = $id;
		$this->name = $name;
		$this->description = $desc;
	}
}

?>