console.log('hello from SBApp.js');

var app = angular.module('SBApp', [], function($httpProvider){
	// Use x-www-form-urlencoded Content-Type
	$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
	var param = function(obj) {
		var query = '', name, value, fullSubName, subName, subValue, innerObj, i;

		for(name in obj) {
			value = obj[name];

		if(value instanceof Array) {
			for(i=0; i<value.length; ++i) {
				subValue = value[i];
				fullSubName = name + '[' + i + ']';
				innerObj = {};
				innerObj[fullSubName] = subValue;
				query += param(innerObj) + '&';
			}
		}
		else if(value instanceof Object) {
			for(subName in value) {
				subValue = value[subName];
				fullSubName = name + '[' + subName + ']';
				innerObj = {};
				innerObj[fullSubName] = subValue;
				query += param(innerObj) + '&';
			}
		}
		else if(value !== undefined && value !== null)
			query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
		}

		return query.length ? query.substr(0, query.length - 1) : query;
	};

	  // Override $http service's default transformRequest
	$httpProvider.defaults.transformRequest = [function(data) {
		return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
	}];
});

app.controller('AppCtrl', ['$scope', '$http', '$interval', 'lobby', 'game', 'user', 'cards',
	function($scope, $http, $interval, lobby, game, user, cards) {

	$scope.snowflakes = 20;
	$scope.snowing = false;

	$scope.options = false;

	$scope.game = {};
	//$scope.game.status = "Ho, ho, ho! Merry Christmas!";
	$scope.game.active = false;

	$scope.toggleSnow = function(){
		$scope.snowing = !$scope.snowing;
	};

	function refreshLobby(){
		lobby.getLobbyXHR().then(function(){
			$scope.lobby = lobby.getLobby();
			$scope.lobbyTitle = "LOBBY";
		});
		
	}

	function refreshPlayers(){
		if(game.isActive()){
			game.getStatusXHR().then(function(){
				$scope.players = game.getPlayers();
			});
		}
	}

	function refreshGameStatus(){
		if($scope.game.active != game.isActive()){
			$scope.game.active = game.isActive();
			$scope.players = game.getPlayers();
		}
	}

	function getUser(){
		user.getUserXHR().then(function(){
			$scope.activeUser = user.getUser();
		});
	}

	
	$interval(refreshLobby, 10000);
	$interval(refreshGameStatus, 300);
	//$interval(refreshPlayers, 10000);
	getUser();
	
	refreshLobby();
	refreshGameStatus();

	cards.getCardsXHR().then(function(){
		$scope.cards = cards.getCards();
	});

	



	//$scope.number = 5;

}]);




app.factory('cards', ['$http', function($http){
	obj = {};
	cards = [];

	obj.getCards = function(){
		return cards;
	}

	obj.replace = function(cardIndex){
		return $http({
			method: 'GET',
			url: 'getUserCards.php?replace=' + (cardIndex + 1)
		}).then(function successCallback(response) {
			//console.log(response.data);
			cards = response.data;
		}, function errorCallback(response) {
			console.log(response);
		});
	}

	obj.getCardsXHR = function(){
		return $http({
			method: 'GET',
			url: 'getUserCards.php'
		}).then(function successCallback(response) {
			//console.log(response.data);
			cards = response.data;
		}, function errorCallback(response) {
			console.log(response);
		});
	}

	return obj;

}]);


app.factory('game', ['$q', '$http', function($q, $http){
	var obj = {};
	var status = "Ho, ho, ho! Merry Christmas!";
	var active;
	var game = {};
	var lobby = {};
	var players = {};
	var bingos = [];
	var log = false;
	var error = false;

	obj.getStatus = function(){
		return status;
	}

	obj.getGameObject = function(){
		return game;
	}

	obj.isActive = function(){
		return active;
	}

	obj.getLastCalledNumber = function(){
		if(active){
			//console.log(game.calledNumbers[game.calledNumbers.length - 1]);
			return game.calledNumbers[game.calledNumbers.length - 1];
		}
	}

	obj.getCalledNumbers = function(){
		if(active){
			//console.log(game.calledNumbers[game.calledNumbers.length - 1]);
			return game.calledNumbers;
		}
	}

	obj.getLobby = function(){
		return lobby;
	}

	obj.getPlayers = function(){
		return players;
	}

	obj.error = function(){
		return error;
	}

	obj.getBingos = function(){
		return bingos;
	}

	obj.getStatusXHR = function(){
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
				if(log){
					console.log(response.data.game);
					log = false;
				}
				//console.log("a game was received");
				game = response.data.game;
				players = response.data.players;
				bingos = response.data.bingos;
				//notifications.setRawData(bingos);
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

	obj.startGame = function(){
		data = {};
		data.START = true;
		return _gameStatusPost(data);
	}

	obj.callNextNumber = function(){
		data = {};
		data.NEXT = true;
		return _gameStatusPost(data);
	}

	obj.endGame = function(){
		data = {};
		data.END = true;
		return _gameStatusPost(data);
	}

	obj.changeGame = function(type){
		data = {};
		data.CHANGE_TYPE = true;
		data.type = type;
		return _gameStatusPost(data);
	}

	function _gameStatusPost(data) {
		url = 'gameStatus.php'
		return $http.post(url, data).then(
			function successCallback(response){
				//console.log(response);
				//obj.getStatusXHR();
				// response.data;
			},
			function errorCallback(response){
				console.log(response.data);
			}
		);
	}

	return obj;

}]);


app.factory('lobby', ['$q', '$http', function($q, $http){
	var obj = {};
	var lobby = {};

	obj.getLobby = function(){
		return lobby;
	}

	obj.getLobbyXHR = function(){
		//console.log("Getting Lobby");
		return $http({
			method: 'GET',
			url: 'getLobby.php'
		}).then(function successCallback(response) {
			//console.log(response);
			lobby = response.data;
		}, function errorCallback(response) {
			console.log(response);
		});
	}
	return obj;
}]);

app.factory('user', ['$http', function($http){
	var obj = {};
	var user = {};

	obj.getUser = function(){
		return user;
	}

	obj.getUserXHR = function(){
		//console.log("Getting Lobby");
		return $http({
			method: 'GET',
			url: 'getActiveUser.php'
		}).then(function successCallback(response) {
			if(response.data.user){
				user = response.data.user;
			} else if(response.data.error){
				console.log(response.data.error);
			}
		}, function errorCallback(response) {
			console.log(response);
		});
	}
	return obj;
}]);




app.filter('letterForNumber', function() {
	return function(x) {
		x = parseInt(x);
		//console.log(x);
		var letter = '';
		if(x > 0 && x < 16){
			letter = 'S';
		} else if(x >= 16 && x < 31){
			letter = 'a';
		} else if((x >= 31 && x < 46) || (x == 0)){
			letter = 'n';
		} else if(x >= 46 && x < 61){
			letter = 't';
		} else {
			letter = 'A';
		}
		return letter;
	};
});

 function changeBG(color){
	if(color == 'red'){
		$("body").removeClass("bg-grad-yellow");
		$("body").removeClass("bg-grad-green");
		$("body").addClass("bg-grad-red"); 
	} else if(color == 'green'){
		$("body").removeClass("bg-grad-yellow");
		$("body").removeClass("bg-grad-red");
		$("body").addClass("bg-grad-green"); 
	} else {
		$("body").removeClass("bg-grad-red");
		$("body").removeClass("bg-grad-green");
		$("body").addClass("bg-grad-yellow"); 
	}
}

