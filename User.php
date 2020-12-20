<?php

class User {
	
	public $userID;
	public $name;
	public $role;
	public $email;

	function __construct($userID = null, $name = null, $role = null, $email = null){
		if($userID != null){
			$this->userID = $userID;
			$this->name = $name;
			$this->role = $role;
			$this->email = $email;
		}
	}



}

?>