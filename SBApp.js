console.log('hello from SBApp.js');

var app = angular.module('SBApp', []);

app.controller('AppCtrl', ['$scope', '$http', function($scope, $http) {

	$scope.snowflakes = 20;
	$scope.snowing = false;

	$scope.options = false;

	$scope.message = "Ho, ho, ho. Merry Christmas!";


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

	function getCard(){
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

	getCard();

}]);

/*
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 
lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum lorum ipsum 


*/