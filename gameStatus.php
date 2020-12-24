<?php
	require_once 'debugSettings.php';
	require_once 'Game.php';
	require_once 'gameManager.php';
	require_once '../dbinfo/dbcred.php';
	require_once 'DBSessionHandler.php';
	require_once 'LobbyManager.php';

	$error = "";

	try{
		$handler = new DBSessionHandler();
		session_set_save_handler($handler);
		session_start();
	} catch (Exception $e){
		$error = $e->getMessage();
	}
	
	header('Content-Type: application/json');

	if ( !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true ) {
		$status = "Unauthenticated access attempt.";
		$response = array('status' => $status);
		echo json_encode($response);
		exit;
	}
	
	$gameManager = new GameManager();
	$lobbyManager = new LobbyManager();
	$lobby = $lobbyManager->getLobby();

	if(!$lobbyManager->userInLobby($_SESSION['email']) && !$gameManager->userInGame($_SESSION['email'])){
		try {
			$lobbyManager->addUser($_SESSION['email']);
		} catch (Exception $e){
			$error = $e->getMessage();
		}
	}

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
		if($active && isset($_POST['CHANGE_TYPE']) && isset($_POST['type'])){
			$type = htmlspecialchars($_POST['type']);
			$game->setType($type);
			$gameManager->update($game);
		}
		if($active && isset($_POST['REMOVE_PLAYER'])){
			$player = htmlspecialchars($_POST['REMOVE_PLAYER']);
			$gameManager->removePlayerFromGame($player);
			
		}
		if($active && isset($_POST['END']) && isset($_SESSION['role'])){
			$gameManager->end($game);
			// empty activeGamePlayers and put users in lobby
			$gameManager->moveUsersFromGameToLobby();
		}
	}

	if(!$active){
		$status = "The game has not started.";
		$response = array('status' => $status, 'lobby' => $lobby, 'active' => $active);
	} else {
		require_once 'CardManager.php';
		$status = "A game is in progress. Game type: " . $game->types[0];
		$cardManager = new CardManager();
		$players = $gameManager->getActiveGamePlayers();
		$bingos = $game->checkForBingos($players, $cardManager);
		$response = array('game' => $game, 'status' => $status, 'lobby' => $lobby, 'players' => $players, 'bingos' => $bingos, 'active' => $active);
	}

	if(isset($error)){
		$response['error'] = $error;
	}

	echo json_encode($response);

?>