<?php

/** 
 *  © 2020 n8blake
 *  SantA Bingo Card
 *  Generate a new SantA bingo card...
 *  each letter will have an array of 5 numbers from a given range
 *  S: 1-15
 *  a: 16-30
 *  n: 31-45
 *  t: 46-60
 *  A: 61-75
 */

class BingoCard {
	
	//['S':[1, 2, 3, 4, 5], 'a':[16], 

	public $card;

	function __construct()
	{
		$this->card = array(
			"S"=> $this->fiveRandomValues(1, 15),
			"a"=> $this->fiveRandomValues(16, 30),
			"n"=> $this->fiveRandomValues(31, 45),
			"t"=> $this->fiveRandomValues(46, 60),
			"A"=> $this->fiveRandomValues(61, 75),
		);
		$this->card["n"][2] = 0;
	}

	// return an array of 5 random, unique integers
	// between the min and max
	private function fiveRandomValues($min, $max){
		$arr = array();
		while(count($arr) < 5){
			$number = rand($min, $max);
			if(!in_array($number, $arr)){
				// add number
				array_push($arr, $number);
			}
		}
		return $arr;
	}

	// take a json string and turn it into a card
	public function setCard($json){
		$object = json_decode($json);
		if(isset($object->card)){
			$this->card = $object->card;
		}
	}

}


?>