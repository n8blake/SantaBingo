<?php
	require_once 'debugSettings.php';
	require_once 'Game.php';
	require_once 'gameManager.php';
	require_once '../dbinfo/dbcred.php';
	require_once 'DBSessionHandler.php';
	require_once 'CardManager.php';
	$handler = new DBSessionHandler();
	session_set_save_handler($handler);
	session_start();


	if ( !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true ) {
		header('Content-Type: application/json');
		$status = "Unauthenticated access attempt.";
		$response = array('status' => $status);
		echo json_encode($response);
		exit;
	}
	
	$gameManager = new GameManager();


	try {
		$game = new Game();
		// get the game status
		$game->setGame($gameManager->getCurrentGame());
	} catch (Exception $e){
		$game = false;
	}

	$active = false;
	if(is_object($game)){
		if(isset($game->active)){
			$active = true;
		}
	}

	if($_SESSION['role'] == 'overlord' || $_SESSION['role'] == 'manager'){
		if(!$active && isset($_POST['START']) && isset($_SESSION['role'])){
			$game = new Game();
			$gameManager->new($game);
			$game->setGame($gameManager->getCurrentGame());
			// empty lobby and put users in activeGamePlayers
			$gameManager->moveUsersFromLobbyToGame();
		}
		if($active && isset($_POST['NEXT']) && isset($_SESSION['role'])){
			$game->callNextNumber();
			$gameManager->update($game);
		}
		if($active && isset($_POST['END']) && isset($_SESSION['role'])){
			$gameManager->end($game);
			// empty activeGamePlayers and put users in lobby
			$gameManager->moveUsersFromGameToLobby();
		}
	}

	if(!$game){
		$status = "The game has not started.";
	} else {
		$status = "A game is in progress.";
		// check the activeGamePlayers and see if 
		// a player with thier boards have scored
		// in the current game.
	}

	$data = $_POST;

	$response = array('game' => $game, 'status' => $status);

	header('Content-Type: application/json');
	echo json_encode($response);

?>