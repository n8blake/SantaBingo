<?php

	require_once 'debugSettings.php';
	require_once '../dbinfo/dbcred.php';
	require_once 'DBSessionHandler.php';

	$handler = new DBSessionHandler();
	session_set_save_handler($handler);
	session_start();
	header('Content-Type: application/json');

	if ( !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true ) {	
		$status = "Unauthenticated User";
		$response = array('error' => $status);
		echo json_encode($response);
		exit;
	}

	require_once 'CardManager.php';
	require_once 'BingoCard.php';

	$cardManager = new CardManager();
	$cards = $cardManager->getCards($_SESSION['email']);

	if(isset($_GET['allnew']) || !$cards){
		// generate 3 new cards
		if($cards){
			$cardManager->deleteCards($_SESSION['email']);
		} 
		for($i = 0; $i < 3; $i++){
			$newCard = new BingoCard();
			$cardManager->addCard($newCard, $_SESSION['email']);
		}
	} 
	if(isset($_GET['replace'])){
		if($_GET['replace'] == 1 || $_GET['replace'] == 2 || $_GET['replace'] == 3){
			$cardManager->replace($_GET['replace'], $_SESSION['email']);
		}
	}

	$cards = $cardManager->getCards($_SESSION['email']);



	echo json_encode($cards);

?>