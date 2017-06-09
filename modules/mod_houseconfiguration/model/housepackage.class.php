<?php
class Housepackage{
	
	public $id;
	public $name;
	public $description;
    public $area;
    public $floors;
    public $floorheight;
    public $img_path;
	
	function __construct($id,$name, $desc, $area, $floors, $img_path){
		$this->id = $id;
		$this->name = $name;
		$this->description = $desc;
                $this->area = $area;
                $this->floors = $floors;
                $this->img_path = $img_path;
	}
	
}

?>