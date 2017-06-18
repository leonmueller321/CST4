<?php

class ComponentWithArea{
	
	public $id;
	public $name;
        public $area;
        public $price;
	public $price_id;
        public $build_modules_id;
        public $build_modules_name;
        public $levelid;
        
        public function __construct($id, $name, $area,$build_modules_id, $build_modules_name, $price_id, $price, $levelid) {
            $this->id = $id;
            $this->name = $name;
            $this->area = $area;
            $this->build_modules_id = $build_modules_id;
            $this->build_modules_name = $build_modules_name;
            $this->price_id = $price_id;
            $this->price = $price;
            $this->levelid = $levelid;
        }
}

