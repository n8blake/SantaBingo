console.log('hello from SBApp.js');

var app = angular.module('SBApp', []);

app.controller('AppCtrl', ['$scope', function($scope) {

	$scope.snowflakes = 20;
	$scope.snowing = true;

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

}]);