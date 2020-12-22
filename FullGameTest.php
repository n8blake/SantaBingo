<?php

	// Full Game Test
	require_once 'debugSettings.php';
	require_once 'Game.php';
	require_once 'gameManager.php';
	require_once '../dbinfo/dbcred.php';
	require_once 'DBSessionHandler.php';
	require_once 'LobbyManager.php';
	require_once 'CardManager.php';

	$handler = new DBSessionHandler();
	session_set_save_handler($handler);
	session_start();
	header('Content-Type: application/json');

	//echo "Hello world";

	if ( !isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true ) {
		header('Content-Type: application/json');
		$status = "Unauthenticated access attempt.";
		$response = array('status' => $status);
		echo json_encode($response);
		exit;
	}

	$gameManager = new gameManager();
	$lobbyManager = new LobbyManager();
	$cardManager = new CardManager();

	$lobby = $lobbyManager->getLobby();
	echo "lobby:";
	echo json_encode($lobby);

	try {
		$game = new Game();
		// get the game status
		$game->setGame($gameManager->getCurrentGame());
	} catch (Exception $e){
		$game = false;
	}

	$active = false;
	if(is_object($game)){
		if(isset($game->active)){
			$active = true;
			$game->resetNumbers();
			$gameManager->update($game);
		}
	}
	echo " \n\nactive:";
	echo json_encode($active);

	// Start a New Game
	if(!$active){
		$game = new Game();
		$gameManager->new($game);
		$game->setGame($gameManager->getCurrentGame());
		// empty lobby and put users in activeGamePlayers
		$gameManager->moveUsersFromLobbyToGame();
	}

	//Run 5 rounds of the game
	$players = $gameManager->getActiveGamePlayers();
	echo " \n\nactive players:";
	echo json_encode($players);

	//$game->callNextNumber();
	//$gameManager->update($game);

	function checkForBingos($game, $players, $cardManager){
		$bingos = array();
		foreach ($game->types as $type) {
			// echo " \n\nchecking for '.$type.':";
			foreach ($players as $player) {
				$email = $player->email;
			    $cards = $cardManager->getCards($email);
			    //$bingos[$email] = array();
			    foreach ($cards as $card) {
			    	// echo " \ncheck:";
			    	// echo json_encode($card);
			    	//$check = $game->bingo($card);
			    	$check = $game->checkCard($type, $card);
			    	// echo " \ncheck:";
			    	// echo json_encode($check);
			    	$bingoData = array();
			    	if($check){
			    		if(!isset($bingos[$email])){
			    			$bingos[$email] = array();
			    		}
			    		$_data = $game->bingo($card);
			    		// echo " email: " . $email . " > ";
			    		// echo json_encode($_data);
			    		array_push($bingos[$email], $_data);
			    	}
			    	//array_push($bingos[$email], $bingoData);
			    }

			}
		}
		return $bingos;
	}


	// Play 25 rounds, check if a user has got bingo
	for($i = 0; $i < 30; $i++){
		$game->callNextNumber();
		$gameManager->update($game);
		
	}

	
	echo " \n\ngame:";
	echo json_encode($game);
	$bingos = checkForBingos($game, $players, $cardManager);
	echo "\n\nbingos:";
	echo json_encode($bingos);
	echo "\n \n";





	// set game to xes
	// Play 45 rounds, check if a user has got bingo
	
	//echo " \n\nResetting numbers.";
	//$game->resetNumbers();
	
	echo " \n\nChange game to xes:";
	

	$game->addType('xes');
	$game->removeType('bingo');

	echo " \n\nxes bingos:\n";
	$bingos = checkForBingos($game, $players, $cardManager);
	echo json_encode($bingos);
	echo " \n\nCall 30 more numbers.\n";
	for($i = 0; $i < 30; $i++){
		$game->callNextNumber();
		$gameManager->update($game);
	}

	$bingos = checkForBingos($game, $players, $cardManager);
	//echo " \ngame:";
	//echo json_encode($game);


	echo "\n \nxes bingos again:\n";
	echo json_encode($bingos);
	echo "\n \n";


	// set game to window
	// Play 25 rounds, check if a user has got bingo
	// $game->resetNumbers();

	echo " \n\nchange type to window:";
	$game->setType('window');

	$bingos = checkForBingos($game, $players, $cardManager);
	echo " \nwindow bingos:";
	echo json_encode($bingos);

	echo " \n\nCall 10 more numbers.\n";
	for($i = 0; $i < 10; $i++){
		$game->callNextNumber();
		$gameManager->update($game);
		
	}

	$bingos = checkForBingos($game, $players, $cardManager);
	echo " \nwindow bingos after:";
	echo json_encode($bingos);

	// set game to blackout
	// Play 25 rounds, check if a user has got bingo
	//$game->resetNumbers();

	echo " \n\nchange type to blackout:";
	$game->setType('blackout');

	$bingos = checkForBingos($game, $players, $cardManager);
	echo " \nblackout bingos:\n";
	echo json_encode($bingos);

	echo " \n\nCall last 5 numbers.\n";
	for($i = 0; $i < 5; $i++){
		try {
			$game->callNextNumber();
		} catch (Exception $e){
			echo $e->getMessage();
		}
		$gameManager->update($game);
		
	}

	$bingos = checkForBingos($game, $players, $cardManager);
	echo "\nblackout bingos after all number called (everyone should win):\n";
	echo json_encode($bingos);

	$game->setType('bingo');
	$gameManager->update($game);

	// end game
	echo "\n\nend game.\n";
	$gameManager->end($game);


?>

