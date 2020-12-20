<?php 
	// Card Manager

/**
 * 
 */

require_once 'BingoCard.php';

class cards {
	public $cards;
}

class CardManager
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
	// Provided a user email (string)
	// Return an array of cards;
	public function getCards($email){
		$sql = "SELECT `cards` from `cards` WHERE cards.userID=(SELECT `userID` FROM `users` WHERE users.email=".$this->db->quote($email).")";
		$result = $this->db->query($sql);
		$data = $result->fetch(PDO::FETCH_ASSOC);
		if ($data && $data['cards']) {
			//preDump($data);
			return json_decode($data['cards']);
		} 
		return array();
	}


	// ADD A NEW CARD FOR A USER
	public function addCard($card, $email){
		$cards = $this->getCards($email);
		if($cards){
			//$cards = json_decode($_cards);
			array_push($cards, $card);
		} else {
			$cards = Array($card);
		}
		$this->setCards($cards, $email);
	}

	public function replace($cardNumber, $email){
		if($cardNumber){
			$cardNumber = intval($cardNumber);
			if($cardNumber > 0 && $cardNumber < 4){
				$cards = $this->getCards($email);
				$cards[$cardNumber - 1] = new BingoCard();
				$this->setCards($cards, $email);
			}
		}
	}

	// UPDATE THE CARDS JSON DATA FOR A USER
	// @params $cards is a an object, with a key ['cards']

	public function setCards($cards, $email){
		$cards = json_encode($cards);
		$_cards = $this->getCards($email);
		if(!$_cards){
			// INSERT INTO
			$sql = "INSERT INTO `cards`(`userID`,`cards`) VALUES ((SELECT `userID` FROM `users` WHERE users.email=".$this->db->quote($email)."), ".$this->db->quote($cards).") ";
			try {
				$result = $this->db->query($sql);
			} catch (PDOException $e) {
				return $e->getMessage();
			}
		} else {
			// UPDATE
			$sql = "UPDATE `cards` SET cards.cards=".$this->db->quote($cards)." WHERE cards.userID=((SELECT `userID` FROM `users` WHERE users.email=".$this->db->quote($email).")) ";
			try {
				$result = $this->db->query($sql);
			} catch (PDOException $e) {
				return $e->getMessage();
			}
		}
	}

	public function deleteCards($email){
		$sql = "DELETE FROM `cards` WHERE cards.userID=(SELECT `userID` FROM `users` WHERE users.email=".$this->db->quote($email).")";
		try {
			$result = $this->db->query($sql);
		} catch (PDOException $e) {
			return $e->getMessage();
		}
	}

}

?>