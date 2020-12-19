<?php
	require_once 'debugSettings.php';
	require_once '../dbinfo/dbcred.php';
	require_once 'DBSessionHandler.php';
	$handler = new DBSessionHandler();
	session_set_save_handler($handler);
	session_start();

	// Check if the user is logged in, if not then redirect him to login page
	if ( !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true ) {
		header("location: login.php");
		//var_dump($_SESSION);
		exit;
	}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Santa Bingo</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="styles.css">

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.8.2/angular.min.js"></script>

	<script type="text/javascript" src="SBApp.js"></script>

</head>
<body class="bg-grad-red" ng-app="SBApp">
<div ng-controller="AppCtrl" ng-cloak="">
	<div class="snowflakes" aria-hidden="true" ng-if="snowing">
		<div class="snowflake" ng-repeat="x in [].constructor(snowflakes) track by $index">❅</div>
	</div>	

	<div class="container">
		<div class="d-flex justify-content-center">
			<h1>SANTA BINGO</h1>
		</div>

		<div class="d-flex justify-content-center" ng-show="options">
			<button class="btn btn-block btn-outline-light m-2" ng-click="changeBG('red')">RED</button>
			<button class="btn btn-block btn-outline-light m-2" ng-click="changeBG('green')">GREEN</button>
			<button class="btn btn-block btn-outline-light m-2" ng-click="changeBG('yellow')">YELLOW</button>
			<button class="btn btn-block btn-outline-light m-2" ng-click="toggleSnow()">Toggle Snow</button>
			<a class="btn btn-block btn-outline-light m-2" href="logout.php">LOGOUT</a>
		</div>


		<div class="row">
			<div class="col" style="text-align: center;" ng-repeat="(k, v) in card">
				<div style="font-size: 50px;"><strong>{{k}}</strong></div>
				<div ng-repeat="number in v" style="height: 100px; border-style: solid; border-color: #FFFFFF55;">
					{{number}}
				</div>
			</div>
		</div>

	</div>


</div>
</body>
</html>