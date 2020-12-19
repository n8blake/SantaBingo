<?php

	// Game Manager Test

	error_reporting(E_ALL);
	ini_set('display_errors', 'on');
	//include 'BingoCard.php';
	//include 'User.php';
	include 'Game.php';

	require 'gameManager.php';


	$manager = new GameManager();

	$game = $manager->getCurrentGame();
	var_dump($game);

?>