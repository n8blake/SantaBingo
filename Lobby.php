<?php

	/**
	 * 
	 */
	class Lobby 
	{

		public $lobby;

		function __construct()
		{
			$this->lobby = [];		
		}

		// get lobby
		public function getLobby(){
			return $this->lobby();
		}

		// add person to lobby
		public function addUser($user){
			if(!in_array($user, $this->lobby)){
				array_push($this->lobby, $user);
			}
		}

		// remove person from lobby
		public function removeUser($user){
			if(!in_array($user, $this->lobby)){
				$index = array_search($user, $this->lobby);
				unset($this->lobby[$index]);
			}
		}

	}

?>