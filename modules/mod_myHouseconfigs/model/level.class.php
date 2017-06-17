<?php
class Level{
	
	public $id;
	public $name;
	public $area;
        public $sketch;
        public $height;
        public $house_package_id;
	
	function __construct($id,$name, $area, $sketch, $height, $house_package_id ){
		$this->id = $id;
		$this->name = $name;
                $this->area = $area;
                $this->sketch = $sketch;
                $this->height = $height;
                $this->house_package_id = $house_package_id;
	}
}

?>