<?php
	require_once 'debugSettings.php';
	require_once 'Game.php';
	require_once 'gameManager.php';
	// get the game status

	

	// get the current active game

	// if no game is active, 
	$manager = new GameManager();
	try {
		$game = new Game();
		$game->setGame($manager->getCurrentGame());
	} catch (Exception $e){
		$game = false;
	}

	if(isset($_POST['START']) && isset($_SESSION['role'])){
		if($_SESSION['role'] == 'overlord' || $_SESSION['role'] == 'manager'){
			$game = new Game();
			$manager->new($game);
			$game->setGame($manager->getCurrentGame());
		}
	}

	if(!$game){
		$status = "The game has not started.";
	} else {
		$status = "A game is in progress.";
	}

	$response = array('game' => $game, 'status' => $status);

	header('Content-Type: application/json');
	echo json_encode($response);

?>