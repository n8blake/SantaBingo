<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 'on');
	include 'BingoCard.php';
	include 'User.php';
	include 'Game.php';

	$user1 = new User(1, "Mike", 'player');
	$user2 = new User(2, "Laura", 'player');
	$user3 = new User(3, "Cooper", 'manager');

	$card1 = new BingoCard();
	$card2 = new BingoCard();
	$card3 = new BingoCard();

	$card1JSON = '{"card":{"S":[13,10,6,15,4],"a":[26,19,17,22,18],"n":[31,38,0,45,41],"t":[51,46,50,52,56],"A":[73,74,64,70,63]}}';
	$card2JSON = '{"card":{"S":[14,5,4,12,15],"a":[16,24,28,25,21],"n":[42,41,0,37,43],"t":[49,55,58,48,47],"A":[61,75,73,66,65]}}';
	$card3JSON = '{"card":{"S":[14,13,11,8,1],"a":[26,24,25,23,27],"n":[36,42,0,37,31],"t":[50,55,58,51,49],"A":[61,71,73,70,69]}}';


	$calledNumberJSON = '[0,3,4,5,6,10,12,13,15,16,17,18,19,20,22,23,24,25,26,28,31,37,38,41,44,45,46,49,50,51,52,55,56,57,61,63,64,69,70,73,74,75]';


	echo json_encode($user1);
	echo json_encode($user2);
	echo json_encode($user3);

	echo "<br><br>";
	echo json_encode($card1);
	echo json_encode($card2);
	echo json_encode($card3);

	echo "<br><br>";
	echo "JSON DECODE";

	$card1->setCard($card1JSON);
	$card2->setCard($card2JSON);
	$card3->setCard($card3JSON);

	echo "<br>";
	echo json_encode($card1);
	echo json_encode($card2);
	echo json_encode($card3);

	$game = new Game();

	echo "<br>First call: <br>";
	echo json_encode($game->calledNumbers);

	for($i = 1; $i < 25; $i++){
		$game->callNextNumber();
	}

	echo "<br>";
	echo "<br>25 calls: <br>";
	echo json_encode($game->calledNumbers);
	echo "<br>count: <br>";
	echo count($game->calledNumbers);
	echo "<br>";
	echo "<br>Reset numbers: <br>";
	$game->setNumbers($calledNumberJSON);
	echo json_encode($game->calledNumbers);

	echo "<br><br>";
	echo "Card 1: <br>";
	echo json_encode($game->bingo($card1));

	echo "<br><br>";
	echo "Card 2: <br>";
	echo json_encode($game->bingo($card2));

	echo "<br><br>";
	echo "Card 3: <br>";
	echo json_encode($game->bingo($card3));

	echo "<br><br>";

	echo "Game 2, X :";
	$game2 = new Game();
	$game2->setNumbers($calledNumberJSON);

	echo "<br>";
	echo "Card 1: <br>";
	echo json_encode($game2->xes($card1));

	echo "<br>";
	echo "Card 3: <br>";
	echo json_encode($game2->xes($card3));

	echo "<br><br>Game 3, Window :";
	$game3 = new Game();
	$game3->setNumbers($calledNumberJSON);

	echo "<br>";
	echo "Card 1: <br>";
	echo json_encode($game3->window($card1));

	echo "<br>";
	echo "Card 2: <br>";
	echo json_encode($game3->window($card2));

	echo "<br><br>Game 4, BLACKOUT :";
	$game4 = new Game();
	$game4->setNumbers($calledNumberJSON);

	echo "<br>";
	echo "Card 1: <br>";
	echo json_encode($game4->blackout($card1));
	echo "<br>";
	echo "Card 3: <br>";
	echo json_encode($game4->blackout($card3));

?>