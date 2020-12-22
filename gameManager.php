<?php

require_once 'debugSettings.php';
require_once '../dbinfo/dbcred.php';
require_once 'Game.php';
require_once 'User.php';
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

	public function userInGame($email){
		$sql = "SELECT `userID` FROM `activeGamePlayers` WHERE activeGamePlayers.userID=(SELECT users.userID FROM users WHERE users.email=". $this->db->quote($email) .")"; 
		try {
			$result = $this->db->query($sql);
			$data = $result->fetch(PDO::FETCH_ASSOC);
			if($data) {
				return true;
			} 
			return false;
		} catch (PDOException $e) {
			return $e->getMessage();
		}
	}

	public function new($game){
		$types = json_encode($game->types);
		$called_numbers = json_encode($game->calledNumbers);
		$sql = "INSERT INTO `games` (`gameID`, `start_time`, `end_time`, `game_types`, `called_numbers`, `active`) VALUES (NULL, CURRENT_TIMESTAMP, NULL, ". $this->db->quote($types) .", ". $this->db->quote($called_numbers) .", '1')";

		try {
			return $this->db->query($sql);
		} catch (PDOException $e) {
			return $e->getMessage();
		}
	}

	public function moveUsersFromLobbyToGame(){
		//INSERT `activeGamePlayers` (SELECT * FROM `lobby`)
		$sql = "INSERT `activeGamePlayers` (SELECT * FROM `lobby`); DELETE FROM `lobby` WHERE 1=1;";
		try {
			return $this->db->query($sql);
		} catch (PDOException $e) {
			echo $e->getMessage();
			return $e->getMessage();
		}
	}

	public function moveUsersFromGameToLobby(){
		$sql = "INSERT `lobby` (SELECT * FROM `activeGamePlayers`); DELETE FROM `activeGamePlayers` WHERE 1=1;";
		try {
			return $this->db->query($sql);
		} catch (PDOException $e) {
			echo $e->getMessage();
			return $e->getMessage();
		}
	}

	// Return a list of users in the active game
	public function getActiveGamePlayers(){
		$sql = "SELECT activeGamePlayers.userID as userID, users.name as name, users.role as role, users.email as email FROM activeGamePlayers JOIN `users` ON users.userID=activeGamePlayers.userID";
		//$sql = "SELECT * FROM `lobby`";
		$result = $this->db->query($sql);
		//preDump($result);
		//$data = $result->fetch(PDO::FETCH_ASSOC);
		$data = $result->fetchAll(PDO::FETCH_CLASS, "User");
		if ($data) {
			return $data;
		} 
		return false;
	}

	// update a game
	public function update($game){
		///echo "<br> Updating game: " . $game->gameID .". <br>";
		$types = json_encode($game->types);
		$called_numbers = json_encode($game->calledNumbers);
		$sql = "UPDATE `games` SET `game_types`=".$this->db->quote($types).",`called_numbers`=".$this->db->quote($called_numbers)." WHERE `gameID`=" . $this->db->quote($game->gameID);
		// echo "<br>";
		// echo $sql;
		// echo "<br>";
		try {
			return $this->db->query($sql);
		} catch (PDOException $e) {
			echo $e->getMessage();
			return $e->getMessage();
		}
	}

	// end a game
		public function end($game){
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