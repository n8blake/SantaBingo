<?php

require_once 'debugSettings.php';
require_once 'DBSessionHandler.php';
require_once 'CredentialsHandler.php';
require_once '../dbinfo/dbcred.php';

$showError = false;
$errorDetails = "";
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
	header("location: index.php");
	exit;
}

$email = "";
$name = "";

if (isset($_POST['email'])) {	
    if (!empty($_POST['email'])) {
        $email = $_POST['email'];
    }
}

if (isset($_POST['name'])) {	
    if (!empty($_POST['name'])) {
        $name = $_POST['name'];
    }
}

// Verify credentials
if ($email != "") {
	$credentialsHandler = new CredentialsHandler();

    if ($credentialsHandler->validate($email)) {
		try{
			$handler = new DBSessionHandler();
			session_set_save_handler($handler);
			session_start();
		} catch (Exception $e){
			$errorDetails = $e->getMessage();
		}

        $_SESSION["loggedin"] = true;
        $_SESSION['email'] = $email;

        require_once('UserManager.php');
        $userManager = new UserManager();
        if(isset($_SESSION['email'])){
			if(!isset($_SESSION['role'])){
				$_SESSION['userObject'] = $userManager->getUserByEmail($_SESSION['email']);
				$_SESSION['role'] =  $_SESSION['userObject']['role'];
			}
		}
		$GLOBALS['loggingIn'] = true;
        header("location: index.php");

    } else if($name != ""){
        $credentialsHandler->new($email, $name);
	    if ($credentialsHandler->validate($email)) {
			try{
				$handler = new DBSessionHandler();
				session_set_save_handler($handler);
				session_start();
			} catch (Exception $e){
				$errorDetails = $e->getMessage();
			}

	        $_SESSION["loggedin"] = true;
	        $_SESSION['email'] = $email;
       		header("location: index.php");
       		exit;
	    } else {
	    	$showError = true;
	    }
    }
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" copyright="BLAKEink. 2020">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php include 'ogData.htm'; ?>
	<title>Login</title>
	<link rel="canonical" href="https://blake-ink.com/SantaBingo/">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="preconnect" href="https://fonts.gstatic.com"> 
	<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,900;1,300&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="styles.css">
	<link rel="icon" href="https://blake-ink.com/SantaBingo/favicon-32x32.png">
	<link rel="apple-touch-icon" href="/path/to/apple-touch-icon.png">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.2/angular.min.js"></script>

	<script type="text/javascript" src="LoginApp.js"></script>

</head>
<body class="bg-grad-red" ng-app="LoginApp">
<div ng-controller="AppCtrl">
	<div class="d-flex justify-content-center">
		<!--<h1>SANTA BINGO</h1>-->
		<img class="logoHero" src="./SVG/SB_logo_red.svg" ng-if="!game.active">
	</div>

	<div ng-if="!isLoggedIn" class="text-center">
		
		<form class="form-signin" method="post" action="login.php" >
			<h1 class="h3 mb-3 font-weight-normal">COME JOIN THE PARTY!</h1>
			<label for="inputEmail" class="sr-only">Email address</label>
			<input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>
			<label for="loginName" class="sr-only">Name</label>
			<input type="text" id="loginName" name="name" class="form-control" placeholder="Name" required>

			<button class="btn btn-lg btn-outline-light btn-block" type="submit">{{action}}</button>

		

			<?php

 			if($showError){
 				echo "<br><div class='alert alert-danger'><strong>Oops!</strong> <p>There was a problem logging you in. Make sure you have a name filled in.</p>
 				<pre>".$errorDetails."</pre>
 				</div>";
 			}

		?>

		</form>

	</div>
</div>
</body>
</html>

