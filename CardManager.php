<?php 
	// Card Manager

/**
 * 
 */

class DBCard {
	public $card;
}

class CardManager extends AnotherClass
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

	// GET CARDS BY USER EMAIL

	// ADD A NEW CARD FOR A USER
	public function addCard($card, $email){
		$card = json_encode($card);

		$sql = "INSERT INTO `cards`(`userID`,`card`) VALUES ((SELECT `userID` FROM `users` WHERE users.email=".$this->db->quote($email)."), ".$this->db->quote($card).") "
	}

	// UPDATE A CARD FOR A USER


}

?>