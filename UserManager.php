<?php

require_once 'debugSettings.php';
require_once '../dbinfo/dbcred.php';
require_once('user.php');

/**
 * 
 */
class UserManager
{
	
	protected $db;

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

	public function getUserByEmail($email){
		$email = $this->db->quote($email);
		$sql = "SELECT userID, name, role, email FROM `users` WHERE `email`=" . $email;
		try {
			$result = $this->db->query($sql);
			$data = $result->fetch(PDO::FETCH_ASSOC);
			if($data){
				return $data;
			}
			return false;
		} catch (PDOExcption $e){
			return $e->getMessage();
		} 
	}

}

?>