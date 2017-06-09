<?php
class Housepackage{
	
	public $id;
	public $name;
	public $description;
        public $area;
        public $floors;
        public $floorheight;
        public $image_path;
	
	function __construct($id,$name, $desc, $area, $floors, $image_path){
		$this->id = $id;
		$this->name = $name;
		$this->description = $desc;
                $this->area = $area;
                $this->floors = $floors;
                $this->image_path = $image_path;
	}
	
}

?>