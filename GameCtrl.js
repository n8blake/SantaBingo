app.controller('GameCtrl', ['$scope', '$interval', 'game', 'cards', function($scope, $interval, game, cards){

	$scope.game = {};
	$scope.currentBGColor = 'red';
	$scope.calledNumbersListShow = true;

	$scope.columns = ['S', 'a', 'n', 't', 'A'];
	$scope.rows = [0, 1, 2, 3, 4];



	$scope.startGame = function(){
		game.startGame().then(function(){
			$scope.game.status = game.getStatus();
			$scope.game.active = game.isActive();
			$scope.game.calledNumbers = game.getCalledNumbers();
			$scope.game.lastNumber = $scope.game.calledNumbers[$scope.game.calledNumbers.length - 1];
			refreshGame();
		});
	}

	$scope.nextNumber = function(){
		game.callNextNumber().then(function(){
			$scope.game.status = game.getStatus();
			$scope.game.lastNumber = game.getLastCalledNumber();
			refreshGame();
		});
	}

	$scope.endGame = function(){
		game.endGame().then(function(){
			$scope.game.status = game.getStatus();
			$scope.game.active = game.isActive();
			$('#endGameModal').modal('hide');
			refreshGame();
		});
	};

	$scope.marks = [];

	$scope.mark = function(number){
		if($scope.game.calledNumbers.indexOf(number) > -1){
			$scope.marks.push(number);
		}
	}


	function refreshGame(){
		return game.getStatusXHR().then(function(){
			if($scope.game.status != game.getStatus()){
				$scope.game.status = game.getStatus();
			}
			if($scope.game.active != game.isActive()){
				$scope.game.active = game.isActive();
			}
			if($scope.game.active && $scope.currentBGColor != 'green'){
				//check for if you are in a win screen...
				changeBG('green');
				$scope.snowing = false;
			} else if($scope.currentBGColor != 'red') {
				//$scope.snowing = true;
				changeBG('red');
			}
			if($scope.game.calledNumbers != game.getCalledNumbers()){
				//$scope.game.lastNumber = game.getLastCalledNumber();
				$scope.game.calledNumbers = game.getCalledNumbers();
				$scope.game.lastNumber = $scope.game.calledNumbers[$scope.game.calledNumbers.length - 1];
			}
			
		});
	}

	$scope.replaceCard = function(cardIndex){
		console.log("replaceing card " + (cardIndex + 1));
		cards.replace(cardIndex).then(function(){
			$scope.cards = cards.getCards();
			$scope.activeCard = $scope.cards[cardIndex];
		});
	}

	$scope.showCard = function(card){
		$scope.activeCard = card;
	}

	cards.getCardsXHR().then(function(){
		$scope.cards = cards.getCards();
		$scope.activeCard = $scope.cards[0];
	});

	refreshGame().then(function(){
		if($scope.game.calledNumbers.length > 1){
			for(var i = 0; i < $scope.game.calledNumbers.length; i++){
				$scope.mark($scope.game.calledNumbers[i]);
			}
		}
	});

	$interval(refreshGame, 2000);

}]);