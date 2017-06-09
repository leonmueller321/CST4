<?php
class Component{
	
	public $id;
	public $name;
	public $price_id;
        public $build_module_id;
	
	function __construct($id,$name, $price_id,$build_module_id ){
		$this->id = $id;
		$this->name = $name;
                $this->price_id = $price_id;
                $this->build_module_id = $build_module_id;
	}
}

?>