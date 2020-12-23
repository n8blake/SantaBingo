<?php

	require_once 'debugSettings.php';
	require_once 'DBSessionHandler.php';
	require_once 'CredentialsHandler.php';
	require_once '../dbinfo/dbcred.php';

	// create a new account

	if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
		header("location: index.php");
		exit;
	}

	$email = "";
	$password = "";
	$passwordVerification = "";
	$name = "";

	if (isset($_POST['email']) && 
		isset($_POST['name']) && 
		isset($_POST['password']) && 
		isset($_POST['passwordVerification'])) {
		
	    if (!empty($_POST['email']) && 
	    	!empty($_POST['name']) &&
	    	!empty($_POST['password']) && 
	    	!empty($_POST['passwordVerification']) &&
	    	$_POST['password'] == $_POST['passwordVerification']) {
	        $email = $_POST['email'];
	    	$name = $_POST['name'];
	        $password = $_POST['password'];
	        $verification = $_POST['passwordVerification'];
	    } else {
	    	header("location: login.php?error=true");
			exit;
	    }
	}

	// Create New Account and log them in...
	if ($email != "" && $password != "" && $name != "") {
		$credentialsHandler = new CredentialsHandler();
		$credentialsHandler->new($email, $name, $password);
	    if ($credentialsHandler->validate($email, $password)) {
			$handler = new DBSessionHandler();
			session_set_save_handler($handler);
	        session_start();

	        $_SESSION["loggedin"] = true;
	        $_SESSION['email'] = $email;
       		header("location: index.php");
       		exit;
	    } else {
	        //header("location: login.php");
	    }
	}

?>