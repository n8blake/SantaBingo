console.log('hello from LoginApp.js');

var app = angular.module('LoginApp', []);

app.controller('AppCtrl', ['$scope', function($scope) {

	$scope.action = "SIGN IN";
	//$scope.action = "CREATE NEW ACCOUNT";
	$scope.newPassword = "";


	$scope.newAccount = function(){
		$scope.action = "CREATE NEW ACCOUNT";
	};


}]);