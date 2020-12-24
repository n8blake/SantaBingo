<?php

require_once 'debugSettings.php';
require_once 'DBSessionHandler.php';
require_once 'LobbyManager.php';
require_once 'gameManager.php';

$handler = new DBSessionHandler();
session_set_save_handler($handler);
session_start();

if(isset($_SESSION['email'])){
	$lobbyManager = new LobbyManager();
	$gameManager = new gameManager();
	$gameManager->removePlayerFromGame($_SESSION['email']);
	$lobbyManager->removeUserFromLobby($_SESSION['email']);
}


$_SESSION = [];
$ses_params = session_get_cookie_params();

setcookie(session_name(), '', time() - 60, $ses_params['path'],
    $ses_params['domain'], $ses_params['secure'], $ses_params['httponly']);

session_destroy();

header("Location: login.php");