<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 'on');


	include 'BingoCard.php';

	$card1 = new BingoCard();


	


	echo "<pre>";
	echo "<br>";
	echo json_encode($card1);
	echo "<br>";
	echo "<br>";
	//var_dump($card2);
	echo "</pre>";

?>