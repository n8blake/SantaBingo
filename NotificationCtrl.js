app.controller('NotificationCtrl', ['$scope','$interval', 'game', 'notificaitons', function($scope, $interval, game, notificaitons){

	$scope.message = "Hello from Notification Controller.";
	$scope.game = {};
	$scope.game.status = $scope.game.status = "Ho, ho, ho! Merry Christmas!";


	$scope.notification = {};

	$scope.unread = {};
	$scope.read = {};
	$scope.players = {};

	//$('#notificationAlert').alert('close');
	$scope.alertShow = false;

	var delay = false;

	function refreshNotifications(){
		if(!delay){
		notificaitons.getRawData().then(function(){
			//console.log("getting raw data");
			$scope.game.status = game.getStatus();
			$scope.unread = notificaitons.getUnread();
			$scope.read = notificaitons.getRead();
			$scope.players = notificaitons.getPlayers();

			$scope.notification = {};
			$scope.notification.winners = [];

			for(var i = 0; i < $scope.players.length; i++){
				email = $scope.players[i].email;
				var bingoCount = 0;
				for(const property in $scope.unread[email]){
					//console.log($scope.unread[email][property]);
					//cols
					bingoCount += $scope.unread[email][property].columns.length;
					//rows
					bingoCount += $scope.unread[email][property].rows.length;
					//diags
					bingoCount += $scope.unread[email][property].diagonals.length;
				}
				if(bingoCount > 0){
					var winner = {};
					winner.name = $scope.players[i].name;
					winner.bingoCount =  bingoCount;
					$scope.notification.winners.push(winner);
				}
				//console.log($scope.players[i].name + " got " + bingos + " bingos");
			}
			//console.log($scope.unread);
			if($scope.notification.winners.length > 0){
				$scope.notification.title = "Winner!";
				$scope.notification.type = 'win';
				$scope.alertShow = true;
				//$('#notificationAlert').alert();
				//$('#notificationModal').modal('show');
			}
		});
		}
	}

	function readNotifications(){
		delay = true;
		notificaitons.readNotifications();
		$scope.notification = {};
		$scope.alertShow = false;
		delay = false;
	}

	$interval(refreshNotifications, 2000);
	//$interval(readNotifications, 15000);
	//$('#notificationModal').modal('show');

	refreshNotifications();

	$scope.readNotifications = function(){
		// move unread to read
		// set unread to empty...
		readNotifications();
		//notificaitons.readNotifications();
		//$scope.notification = {};
		//$scope.alertShow = false;
	}

}]);

app.factory('notificaitons', ['$http', function($http){
	obj = {};
	rawData = {};
	read = {};
	unread = {};
	players = {};
	game = {};
	log = true;
	reading = false;

	obj.getUnread = function(){
		return unread;
	}

	obj.getRead = function(){
		return read;
	}

	obj.getPlayers = function(){
		return players;
	}

	obj.readNotifications = function(){
		reading = true;
		// console.log('before');
		// console.log(unread);
		// console.log(read);
		for(var i = 0; i < players.length; i++){
			email = players[i].email;
			for(const property in unread[email]){
				//console.log(unread[email][property]);
				if(read[email][property].columns == undefined){
					read[email][property].columns = [];
				}
				if(read[email][property].rows == undefined){
					read[email][property].rows = [];
				}
				if(read[email][property].diagonals == undefined){
					read[email][property].diagonals = [];
				}

				for(var c = 0; c < unread[email][property].columns.length; c++){
					var unReadColumn = unread[email][property].columns[c];
					if(read[email][property].columns.indexOf(unReadColumn) == -1){
						read[email][property].columns.push(unReadColumn);
					}
				}

				for(var r = 0; r < unread[email][property].rows.length; r++){
					var row = unread[email][property].rows[r];
					if(read[email][property].rows.indexOf(row) == -1){
						read[email][property].rows.push(row);
					}
				}

				for(var d = 0; d < unread[email][property].diagonals.length; d++){
					var diag = unread[email][property].diagonals[d];
					if(read[email][property].diagonals.indexOf(diag) == -1){
						read[email][property].diagonals.push(diag);
					}
				}

				//read[email][property].columns = read[email][property].columns.concat(read[email][property].columns, unread[email][property].columns);
				//read[email][property].rows = read[email][property].rows.concat(read[email][property].rows, unread[email][property].rows);
				//read[email][property].diagonals = read[email][property].diagonals.concat(read[email][property].diagonals, unread[email][property].diagonals);
			}
			unread[email] = 0;
			//unread[email] = {};
		}
		// console.log('after');
		// console.log(unread);
		// console.log(read);
		reading = false;
	}

	function getStatusXHR(){
		return $http({
			method: 'GET',
			url: 'gameStatus.php'
		}).then(function successCallback(response) {
			//console.log(response);
			if(response.data.status){
				status = response.data.status;
			}
			if(response.data.lobby){
				lobby = response.data.lobby;
			}
			if(response.data.error){	
				error = response.data.error;
			}
			if(response.data.game){
				
				//console.log(response.data.game);
				
				//console.log("a game was received");
				game = response.data.game;
				players = response.data.players;
				rawData = response.data.bingos;
				//console.log(rawData);
				update();
			}
			if(response.data.active){
				active = response.data.active;
			} else {
				active = false;
			}
			
		}, function errorCallback(response) {
			console.log(response);
		});
	}


	function update(){
		//var players = game.getPlayers();
		for(var p = 0; p < players.length; p++){
			var email = players[p].email;
			//console.log(email);
			if(unread[email] == undefined || unread[email] == 0) unread[email] = {};
			if(read[email] == undefined) read[email] = {};
			if(rawData[email] != undefined && !reading){

				for(var i = 0; i < rawData[email].length; i++){
					var cardID = rawData[email][i].cardID;
					//console.log(cardID);
					if(cardID == undefined){
						break;
					}
					if(read[email][cardID] == undefined){
						read[email][cardID] = {};
						read[email][cardID].columns = [];
						read[email][cardID].rows = [];
						read[email][cardID].diagonals = [];
					} 

					if(unread[email][cardID] == undefined){
						unread[email][cardID] = {};
						unread[email][cardID].columns = [];
						unread[email][cardID].rows = [];
						unread[email][cardID].diagonals = [];
					}
					// go through cols, rows, diags of rawdata[emails]
					// if not in read, check unread,
					// if not in unread, then add to unread
					// of these are arrays of numbers
					rawCols = rawData[email][i].columns;
					rawRows = rawData[email][i].rows;
					rawDiagonals = rawData[email][i].diagonals;
					// console.log(rawCols);
					// console.log(rawRows);
					// console.log(rawDiagonals);
					// console.log("hello from 126");
						for(var c = 0; c < rawCols.length; c++){
							var col = rawCols[c];
							//console.log(col);
							if(read[email][cardID].columns.indexOf(col) == -1){
								if(unread[email][cardID].columns.indexOf(col) == -1){
									unread[email][cardID].columns.push(col);
								}
							}
						}




					//console.log("hello from 141");
						for(var r = 0; r < rawRows.length; r++){
							var row = rawRows[r];
							//console.log(row);
							if(read[email][cardID].rows.indexOf(row) == -1){
								if(unread[email][cardID].rows.indexOf(row) == -1){
									unread[email][cardID].rows.push(row);
								}
							}
						}

					//console.log(unread);
					if(rawDiagonals != undefined){
						for(var d = 0; d < rawDiagonals.length; d++){
							var diag = rawDiagonals[d];
							if(read[email][cardID].diagonals.indexOf(diag) == -1){
								if(unread[email][cardID].diagonals.indexOf(diag) == -1){
									unread[email][cardID].diagonals.push(diag);
								}
							}
						}
					}

				}
			}
		}

		//console.log(unread);
		//console.log(read);
		
	}

	obj.getRawData = function(){
		return getStatusXHR().then(function(){
			update();
		});
	}


	return obj;
}]);