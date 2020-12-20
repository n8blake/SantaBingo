<?php

	// Lobby test

	//echo "<br><strong>Lobby</strong><br><br>";

	require_once 'debugSettings.php';
	require_once '../dbinfo/dbcred.php';
	require_once 'DBSessionHandler.php';
	$handler = new DBSessionHandler();
	session_set_save_handler($handler);
	session_start();
	require_once 'BingoCard.php';
	require_once 'User.php';
	require_once 'Game.php';
	//require_once 'Lobby.php';
	require_once 'LobbyManager.php';

	//echo "<br>";

	$lobbyManager = new LobbyManager();


	$lobby = $lobbyManager->getLobby();
	
	header('Content-Type: application/json');
	echo json_encode($lobby);

?>