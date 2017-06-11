<?php
class CompPrice{
	
	public $id;
	public $name;
	public $preis;
        public $price_id;
        public $build_module_id;
	
	function __construct($id,$name, $preis, $price_id, $build_module_id){
		$this->id = $id;
		$this->name = $name;
		$this->preis = $preis;
                $this->price_id = $price_id;
                $this->build_module_id = $build_module_id;
	}
}

