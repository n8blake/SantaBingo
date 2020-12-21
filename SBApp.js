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
	$scope.game.status = "Ho, ho, ho! Merry Christmas!";

	

	$scope.changeBG = function(color){
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

	$scope.toggleSnow = function(){
		$scope.snowing = !$scope.snowing;
	};


	$scope.startGame = function(){
		game.startGame().then(function(){
			$scope.game.status = game.getStatus();
			$scope.game.active = game.isActive();
			$scope.game.lastNumber = game.getLastCalledNumber();
		});
	}

	$scope.nextNumber = function(){
		game.callNextNumber().then(function(){
			$scope.game.status = game.getStatus();
			$scope.game.lastNumber = game.getLastCalledNumber();
		});
	}

	$scope.endGame = function(){
		game.endGame().then(function(){
			$scope.game.status = game.getStatus();
			$scope.game.active = game.isActive();
			$('#endGameModal').modal('hide');
		});
	};



	function refreshLobby(){
		lobby.getLobbyXHR().then(function(){
			$scope.lobby = lobby.getLobby();
			$scope.lobbyTitle = "LOBBY";
		});
	}

	function refreshGame(){
		game.getStatusXHR().then(function(){
			$scope.game.status = game.getStatus();
			$scope.game.active = game.isActive();
			if($scope.game.active){
				//check for if you are in a win screen...
				$scope.changeBG('green');
				$scope.snowing = false;
			} else {
				//$scope.snowing = true;
				$scope.changeBG('red');
			}
			$scope.game.lastNumber = game.getLastCalledNumber();
		});
	}

	function getUser(){
		user.getUserXHR().then(function(){
			$scope.activeUser = user.getUser();
		});
	}

	$interval(refreshGame, 3000);
	$interval(refreshLobby, 30000);

	getUser();
	refreshGame();
	refreshLobby();

	cards.getCardsXHR().then(function(){
		$scope.cards = cards.getCards();
	});

	$scope.showCard = function(card){
		$scope.activeCard = card;
	}

	$scope.replaceCard = function(cardIndex){
		console.log("replaceing card " + (cardIndex + 1));
		cards.replace(cardIndex).then(function(){
			$scope.cards = cards.getCards();
			$scope.activeCard = $scope.cards[cardIndex];
		});
	}

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
	var status = {};
	var active;
	var game = {};

	obj.getStatus = function(){
		return status;
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

	obj.getStatusXHR = function(){
		return $http({
			method: 'GET',
			url: 'gameStatus.php'
		}).then(function successCallback(response) {
			//console.log(response);
			if(response.data.status){
				status = response.data.status;
			}
			if(response.data.game){
				//console.log("a game was received");
				game = response.data.game;
				active = true;
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

	function _gameStatusPost(data) {
		url = 'gameStatus.php'
		return $http.post(url, data).then(
			function successCallback(response){
				//console.log(response);
				//obj.getStatusXHR();
				// response.data;
			},
			function errorCallback(response){
				error(response.data);
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
