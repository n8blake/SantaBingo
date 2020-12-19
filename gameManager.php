<?php

require_once 'debugSettings.php';
require_once '../dbinfo/dbcred.php';
require_once ('Game.php');

	/* Game Manager
	*
	*
	*
	*/

/**
 *   Game Manger Class
 */

class GameManager {

	protected $db;
	private $game;
	
	function __construct()
	{
		$this->db = $this->dbConnect();
	}

	private function dbConnect() {

		try {
			$db = new PDO('mysql:host=localhost;dbname=santa', DB_USERNAME, DB_PASSWORD);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $db;
		} catch (PDOException $e) {
			//echo $e->getMessage();
			return $e->getMessage();
		}

	}


	public function getCurrentGame(){
		//SELECT hash from `users` WHERE email=$email
		$sql = "SELECT * FROM `games` WHERE `active`=1";
		//$sql = "SELECT * FROM users";

		$result = $this->db->query($sql);
		$data = $result->fetch(PDO::FETCH_ASSOC);

		if ($data) {
			if($data['gameID']){
				return $data;
			}
		} 
		return false;
	}

	public function new($game){
		$types = json_encode($game->types);
		$called_numbers = json_encode($game->calledNumbers);
		$sql = "INSERT INTO `games` (`gameID`, `start_time`, `end_time`, `game_types`, `called_numbers`, `active`) VALUES (NULL, CURRENT_TIMESTAMP, NULL, ". $types .", ". $called_numbers .", '1')";

		try {
			return $this->db->query($sql);
		} catch (PDOException $e) {
			return $e->getMessage();
		}
	}

	// update a game
	public function update($game){
		$types = json_encode($game->types);
		$called_numbers = json_encode($game->calledNumbers);
		$sql = "UPDATE `games` SET `game_types`=".$types.",`called_numbers`=".$called_numbers." WHERE `gameID`=" . $this->db->quote($game->gameID);

		try {
			return $this->db->query($sql);
		} catch (PDOException $e) {
			return $e->getMessage();
		}
	}

	// end a game
		public function end(){
		$sql = "UPDATE `games` SET `end_time`=CURRENT_TIMESTAMP, `active`=0 WHERE `gameID`=" . $this->db->quote($game->gameID);
		try {
			return $this->db->query($sql);
		} catch (PDOException $e) {
			return $e->getMessage();
		}
	}

	// delete a game entry
	public function delete($game){
		$sql = "DELETE FROM `games` WHERE `gameID`=" . $this->db->quote($game->gameID);
		try {
			return $this->db->query($sql);
		} catch (PDOException $e) {
			return $e->getMessage();
		}
	}

}

?>