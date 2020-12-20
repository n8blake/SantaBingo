<?php

	// Game Manager Test
	require_once 'debugSettings.php';
	//include 'BingoCard.php';
	//include 'User.php';
	include 'Game.php';

	require 'gameManager.php';


	$manager = new GameManager();

	//
	
	$game = new Game();

	//$manager->new($game);

	//$gameDB = $manager->getCurrentGame();

	try {
		$game->setGame($manager->getCurrentGame());
	} catch (Exception $e){
		echo $e->getMessage();
	}
	

	echo json_encode($game->getNumbers());
	echo "<br><br>";

	for($i = 0; $i < 1; $i++){
		try {
			$game->callNextNumber();
		} catch (Exception $e){
			echo $e->getMessage();
			break;
		}
		
	}
	echo json_encode($game->calledNumbers);	

	$manager->update($game);
	
	$game->removeType("bingo");
	$game->addType("blackout");

	$manager->update($game);

	try {
		$game->setGame($manager->getCurrentGame());
	} catch (Exception $e){
		echo $e->getMessage();
	}

	echo "<br>";
	echo json_encode($game);

	$manager->end($game);
	//preDump();




?>