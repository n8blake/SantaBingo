console.log('hello from LoginApp.js');

var app = angular.module('LoginApp', []);

app.controller('AppCtrl', ['$scope', function($scope) {

	$scope.action = "SIGN IN";
	//$scope.action = "CREATE NEW ACCOUNT";
	$scope.newPassword = "";


	$scope.toggleAction = function(){
		if($scope.action == "CREATE NEW ACCOUNT"){
			$scope.action = "SIGN IN";
		} else {
			$scope.action = "CREATE NEW ACCOUNT";
		}
	};


}]);