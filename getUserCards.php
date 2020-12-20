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

?>