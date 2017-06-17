<?php
class Price{
	
	public $id;
	public $price;
	
	function __construct($id,$price ){
		$this->id = $id;
		$this->price = $price;
	}
}

?>