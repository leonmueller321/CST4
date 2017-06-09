<?php
class House{
	
	public $id;
	public $name;
	public $area;
        public $description;
        public $user_id;
        public $house_package_id;

	
	function __construct($id,$name, $desc, $area, $uid, $house_package_id){
		$this->id = $id;
		$this->name = $name;
		$this->description = $desc;
                $this->area = $area;
                $this->user_id = $uid;
                $this->house_package_id = $house_package_id;
	}
	
}

?>
