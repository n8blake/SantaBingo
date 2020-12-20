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

app.controller('AppCtrl', ['$scope', '$http', 'lobby', 'game', function($scope, $http, lobby, game) {

	$scope.snowflakes = 20;
	$scope.snowing = false;

	$scope.options = false;

	$scope.game = {};
	$scope.game.status = "Ho, ho, ho! Merry Christmas!";

	lobby.getLobbyXHR().then(function(){
		$scope.lobby = lobby.getLobby();
		console.log($scope.lobby);
	});

	game.getStatusXHR().then(function(){
		$scope.game.status = game.getStatus();
	});

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


	//getCard();

}]);

app.factory('game', ['$q', '$http', function($q, $http){
	var obj = {};
	var status = {};
	var game = {};

	obj.getStatus = function(){
		return status;
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
				game = response.data.game;
			}
			
		}, function errorCallback(response) {
			console.log(response);
		});
	}

	obj.getCards = function(){
		return $http({
			method: 'GET',
			url: 'bingoTest.php'
		}).then(function successCallback(response) {
			console.log(response.data);
			$scope.card = response.data.card;
		}, function errorCallback(response) {
			console.log(response);
		});
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
		console.log("Getting Lobby");
		return $http({
			method: 'GET',
			url: 'lobbyTest.php'
		}).then(function successCallback(response) {
			//console.log(response);
			lobby = response.data;
		}, function errorCallback(response) {
			console.log(response);
		});
	}



	

	return obj;
}]);

