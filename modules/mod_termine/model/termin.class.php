<?php
class Termin{
	
	//public $id;
        public $date;
	public $vorname;
        public $nachname;
        public $terminbest;
        public $user_id;
        public $notiz;
        	
	function __construct( $date, $vorname, $nachname, $terminbest, $user_id, $notiz){
		//$this->id = $id;
                $this->date = $date;
		$this->vorname = $vorname;
                $this->nachname = $nachname;
                $this->terminbest = $terminbest;
                $this->user_id = $user_id;
                $this->notiz = $notiz;
	}
}

