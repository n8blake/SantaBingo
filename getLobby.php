<?php

	// Lobby test



	require_once 'debugSettings.php';
	require_once '../dbinfo/dbcred.php';
	require_once 'DBSessionHandler.php';
	$handler = new DBSessionHandler();
	session_set_save_handler($handler);
	session_start();
	header('Content-Type: application/json');
	if ( !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true ) {
		$status = "Unauthenticated access attempt.";
		$response = array('status' => $status);
		echo json_encode($response);
		exit;
	}


	require_once 'BingoCard.php';
	require_once 'User.php';
	require_once 'Game.php';
	//require_once 'Lobby.php';
	require_once 'LobbyManager.php';
	require_once 'gameManager.php';

	$lobbyManager = new LobbyManager();
	
	if($_SESSION['role'] == 'overlord' || $_SESSION['role'] == 'manager'){
		if(isset($_POST['REMOVE_USER'])) {
			$email = htmlspecialchars($_POST['REMOVE_USER']);
			$lobbyManager->removeUserFromLobby($email);
		}
	}

	$gameManager = new gameManager();

	if(!$lobbyManager->userInLobby($_SESSION['email']) && !$gameManager->userInGame($_SESSION['email'])){
		$lobbyManager->addUser($_SESSION['email']);
	}

	$lobby = $lobbyManager->getLobby();
	
	
	echo json_encode($lobby);

?>