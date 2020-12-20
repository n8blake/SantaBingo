<?php

	// Lobby Manager

/**
 * 
 */
require_once ('User.php');

class LobbyManager 
{
	
	protected $db;
	private $lobby;

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

	// Return a list of users in the lobby
	public function getLobby(){
		$sql = "SELECT lobby.userID as userID, users.name as name, users.role as role, users.email as email FROM lobby JOIN `users` ON users.userID=lobby.userID";
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

	// Add a user to the lobby
	public function addUser($user){
		if(isset($user->userID)){
			$userID = $this->db->quote($user->userID);
			$sql = "INSERT INTO `lobby`(`userID`) VALUES (".$userID.")";
			try {
				$result = $this->db->query($sql);
			} catch (PDOException $e) {
				return $e->getMessage();
			}
			
		}
	}



}

?>