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
	$name = "";

	if (isset($_POST['email']) && isset($_POST['name']) ) {
		
	    if (!empty($_POST['email']) && !empty($_POST['name']) ) {
	        $email = $_POST['email'];
	    	$name = $_POST['name'];
	    } else {
	    	header("location: login.php?error=true");
			exit;
	    }
	}

	// Create New Account and log them in...
	if ($email != "" && $name != "") {
		$credentialsHandler = new CredentialsHandler();
		$credentialsHandler->new($email, $name);
	    if ($credentialsHandler->validate($email)) {
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