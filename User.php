<?php

class User {
	
	public $name;
	public $id;
	public $role;

	function __construct($id, $name, $role){
		$this->name = $name;
		$this->id = $id;
		$this->role = $role;
	}



}

?>