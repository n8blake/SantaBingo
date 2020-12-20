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

	if(!isset($_SESSION['userObject'])){
		if(isset($_SESSION['email'])){
			require_once 'UserManager.php';
			$usrManager = new UserManager();
			try {
				$_SESSION['userObject'] = $usrManager->getUserByEmail($_SESSION['email']);
			} catch (Excpetion $e){
				$status = $e->getMessage();
				$response = array('Error' => $status);
				echo json_encode($response);
				exit;
			}
		} else {
			$status = "Unable to Verify";
			$response = array('Error' => $status);
			echo json_encode($response);
			exit;
		}
	}
	
	$user = $_SESSION['userObject'];
	$response = array('user' => $user);
	echo json_encode($response);

?>