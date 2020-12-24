<?php

	
	/**
	 *  © 2020 n8blake
	 *  SantA Bingo
	 *  Create a Bingo Game
	 *  
	 *  calledNumbers: an array of integers, with the first being 0
	 *	gameID: Int, database id of game
	 *	type: array of strings for each game type: bingo, xes, window, blackout 
	 *	start_time, timestamp from database of when game started
	 *	end_time, timestamp from database of when game ended
	 *

	 *  Initialize the middle value (n2), to be 0
	 *  add 0 to the array of 'calledNumbers'
	 *
	 *  calledNumbers is an array of integers of numbers
	 *  that have been 'called' for a given game.
	 *  
	 */
	
	class Game 
	{
		
		public $gameID;
		public $active;
		public $types;
		public $calledNumbers;
		private $start_time;
		private $end_time;
		//protected $gameManager;

		function __construct()
		{
			$this->calledNumbers = [0];
			$this->types = ["bingo"];
		}

		// public function setGameManager($manager){
		// 	$this->gameManager = $manager;
		// }

		// public function save(){
		// 	if(isset($this->gameManager)){
		// 		$gameManager->update($this);
		// 	}
		// }

		// Return the next number in the game
		public function callNextNumber(){
			$newNumber = 0;
			if(count($this->calledNumbers) >=76){
				throw new Exception('All Numbers Called.');
			}
			do {
				$newNumber = rand(1, 75);
			} while(in_array($newNumber, $this->calledNumbers));
			array_push($this->calledNumbers, $newNumber);
		}

		//pass an array of integers
		public function setNumbers($json){
			$numbers = json_decode($json);
			$this->calledNumbers = $numbers;
			sort($this->calledNumbers);
		}

		public function resetNumbers(){
			$this->calledNumbers = [0];
		}

		public function getNumbers(){
			return $this->calledNumbers;
		}

		public function getTypes(){
			return $this->types;
		}

		public function addType($type){
			// echo "\n";
			// echo json_encode($type);
			// echo "\n";
			// echo json_encode($this->types);
			if(!in_array($type, $this->types)){
				array_push($this->types, $type);
			}
		}

		public function removeType($type){
			//echo "<br>Removing: " . $type . "<br>";
			if(in_array($type, $this->types)){
				//echo "<br>found: " . $type . "<br>";
				$index = array_search($type, $this->types);
				//echo $index;
				$_types = array();
				for($i = 0; $i < count($this->types); $i++){
					if($i !== $index){
						array_push($_types, $this->types[$i]);
					}
				}
				$this->types = $_types;
			}
		}

		public function setType($type){
			$this->types = [$type];
		}

		public function setGame($game){
			if( !isset($game["gameID"]) || 
				!isset($game["game_types"]) ||
				!isset($game["start_time"]) ||
				!isset($game["called_numbers"]) ||
				!isset($game["active"]) 
			  ){ 
				throw new Exception("Invalid Game");
			} 
			$this->gameID = $game["gameID"];
			$this->types = json_decode($game["game_types"]);
			$this->start_time = $game["start_time"];
			$this->end_time = $game["end_time"];
			$this->calledNumbers = json_decode($game["called_numbers"]);
			$this->active = $game["active"];
		}

		// standard game
		// all numbers of a single letter for a card have been called (a column win)
		// the same index of every letter from a card has been called (a row win)
		// a diagonal (i.e. S0, a1, n2, t3, A4) for a card has been called (a diagonal win)


		// Has this card won?
		// If yes, return an array of how many
		// ways it has won
		// If no, return an empty array.
		public function bingo($_card){
			$card;
			if(isset($_card->card)){
				$card = $_card->card;
			} else {
				$card = $_card;
			}
			$bingos = [];
			$bingos['bingo'] = false;
			if(isset($_card->id)){
				$bingos['cardID'] = $_card->id;
			}
			// check of a column win
			$bingoColumns = [];
			foreach ($card as $letter => $column) {
				// echo "<br><br>";
				// echo json_encode($letter);
				// echo "<br>";
				// echo json_encode($column);
				$columnBingo = true;
				foreach ($column as $number) {
					//echo "<br>";
					//echo $number;
					if(!in_array($number, $this->calledNumbers)){
						$columnBingo = false;
					}
				}
				//echo "<br>columnBingo: " . $letter . " " . json_encode($columnBingo);
				if($columnBingo && !in_array($letter, $bingoColumns)) {
					array_push($bingoColumns, $letter);
					$bingos['bingo'] = true;
				}
				
				$bingo = $columnBingo;
			}
			//echo json_encode($bingoColumns);

			// check for a row win
			// the same index for every column must be called
			//
			$bingoRows = [];
			for($row = 0; $row < 5; $row++){
				$rowBingo = true;
				foreach ($card as $letter => $column) {
					$number = $column[$row];
					//echo "<br>";
					//echo json_encode($column[$row]);
					if(!in_array($number, $this->calledNumbers)){
						$rowBingo = false;
					}
				}
				if($rowBingo && !in_array($row, $bingoRows)) {
					array_push($bingoRows, $row);
					$bingos['bingo'] = true;
				}
			}

			// check for a diagonal win \ or /
			// that is:
			// S[0], a[1], n[2], t[3], A[4] are all called
			// OR
			// S[4], a[3], n[2], t[1], A[0] are all called
			$bingoDiagonals = [];
			//echo "<pre>";
			//var_dump($card);
			//echo $card->card->S[0];
			//echo "</pre>";
			if( in_array($card->S[0], $this->calledNumbers) && 
				in_array($card->a[1], $this->calledNumbers) && 
				in_array($card->n[2], $this->calledNumbers) && 
				in_array($card->t[3], $this->calledNumbers) &&
				in_array($card->A[4], $this->calledNumbers)  
			){
				array_push($bingoDiagonals, 1);
				$bingos['bingo'] = true;
			}
			if( in_array($card->S[4], $this->calledNumbers) && 
				in_array($card->a[3], $this->calledNumbers) && 
				in_array($card->n[2], $this->calledNumbers) && 
				in_array($card->t[1], $this->calledNumbers) &&
				in_array($card->A[0], $this->calledNumbers)  
			){
				array_push($bingoDiagonals, 2);
				$bingos['bingo'] = true;
			}

			$bingos['columns'] = $bingoColumns;
			$bingos['rows'] = $bingoRows;
			$bingos['diagonals'] = $bingoDiagonals;

			//$bingos['bingo'] = false;
			return $bingos;
		}

		public function normalBingo($card){
			return (
				count($this->bingo($card)['diagonals']) > 0 ||
				count($this->bingo($card)['columns']) > 0 ||
				count($this->bingo($card)['rows'])
			);
		}

		// X 
			// both diagonals for a card have been called
		public function xes($card){
			return count($this->bingo($card)['diagonals']) == 2;
		}

		// Window
			// The S column and A colums have been called AND
			// the a0, n0, t0 AND a4, n4, t4 for a card have
			// been called
		public function window($card){
			return ( 
				in_array("S", $this->bingo($card)['columns']) &&
				in_array("A", $this->bingo($card)['columns']) &&
				in_array(0, $this->bingo($card)['rows']) &&
				in_array(4, $this->bingo($card)['rows'])
			);
		}
		// BLACKOUT
			// All the numbers for a card have been called
		public function blackout($card){
			return count($this->bingo($card)['columns']) == 5;
		}

		public function checkCard($type, $card){
			switch ($type) {
				case 'X':
					return $this->xes($card);
					break;
				case 'window':
					return $this->window($card);
					break;
				case 'blackout':
					return $this->blackout($card);
					break;
				default:
					return $this->normalBingo($card);
					break;
			}
		}

		public 	function checkForBingos($players, $cardManager){
			$game = $this;
			$bingos = array();
			foreach ($game->types as $type) {
				foreach ($players as $player) {
					$email = $player->email;
				    $cards = $cardManager->getCards($email);
				    foreach ($cards as $card) {
				    	$check = $game->checkCard($type, $card);
				    	$bingoData = array();
				    	if($check){
				    		if(!isset($bingos[$email])){
				    			$bingos[$email] = array();
				    		}
				    		$_data = $game->bingo($card);

				    		array_push($bingos[$email], $_data);
				    	}
				    }

				}
			}
			return $bingos;
		}

	}

	





?>