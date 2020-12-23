<?php

/**
 * 
 */
class CredentialsHandler {

	protected $db;
	
	function __construct()
	{
		$this->db = $this->dbConnect();
	}

	private function dbConnect() {

		try {
			$db = new PDO('mysql:host=localhost;dbname='.DB_NAME, DB_USERNAME, DB_PASSWORD);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $db;
		} catch (PDOException $e) {
			//echo $e->getMessage();
			return $e->getMessage();
		}

	}

	public function validate($email, $password){
		// echo "Validating <br>";
		//SELECT hash from `users` WHERE email=$email
		$sql = "SELECT hash FROM `users` WHERE `email` =". $this->db->quote($email);
		//$sql = "SELECT * FROM users";

		$result = $this->db->query($sql);
		$data = $result->fetch(PDO::FETCH_ASSOC);

		if ($data) {
			if($data['hash']){
				return password_verify($password, $data['hash']);
			}
		} 
		return false;
	}

	public function new($email, $name, $password){
		$email = $this->db->quote($email);
		$name = $this->db->quote($name);
		$h = password_hash($password, PASSWORD_DEFAULT);
		$hash = $this->db->quote($h);
		$sql = "INSERT INTO `users`(`email`, `name`, `hash`) VALUES (". $email . "," . $name . "," . $hash .")";

		try {
			return $this->db->query($sql);
		} catch (PDOException $e) {
			return $e->getMessage();
		}
	}

	// update password for email
	public function update($email, $password){
		$email = $this->db->quote($email);
		$h = password_hash($password, PASSWORD_DEFAULT);
		$hash = $this->db->quote($h);
		$sql = "UPDATE `users` SET `hash`=" . $hash . " WHERE `email`=" .$email;

		try {
			return $this->db->query($sql);
		} catch (PDOException $e) {
			return $e->getMessage();
		}
	}

	// delete account
	public function delete($email){
		$sql = "DELETE FROM `users` WHERE `email`=" . $this->db->quote($email);
		try {
			return $this->db->query($sql);
		} catch (PDOException $e) {
			return $e->getMessage();
		}
	}
}