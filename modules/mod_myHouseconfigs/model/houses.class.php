<?php
class House{
	
	public $id;
	public $name;
	public $items;
        public $gesamtpreis;
        public $user_id;
        public $house_package_id;
        public $img_path;

	
	function __construct($id,$name, $gesamtpreis, $house_package_id, $user_id, $items, $img_path){
		$this->id = $id;
		$this->name = $name;
		$this->items = $items;
                $this->gesamtpreis = $gesamtpreis;
                $this->user_id = $user_id;
                $this->house_package_id = $house_package_id;
                $this->img_path = $img_path;
	}
	
}

?>
