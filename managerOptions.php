<button class="btn btn-block btn-outline-light m-2 ml-n1" ng-hide="game.active" ng-click="startGame()" style="position: relative; top: 45%; margin-bottom: 30px;">
	<strong>start a game</strong>
</button>

<div style="margin-top: 40px;" ng-show="game.active" class="ml-n2">
	<button class="btn btn-block btn-outline-light m-2 "  ng-click="nextNumber()">
		<strong>next card</strong>
	</button>
	
		<button class="btn btn-block btn-outline-secondary m-2 "
	class="btn btn-primary" data-toggle="modal" data-target="#changeGameModal">
			<strong>change game type</strong>
		</button>
		<button class="btn btn-block btn-outline-secondary m-2 "
	class="btn btn-primary" data-toggle="modal" data-target="#endGameModal">
			<strong>end game</strong>
		</button>
	
</div>
<!-- Modal -->
<div class="modal fade" id="endGameModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="endGameModalLabel" aria-hidden="true" style="color: #333;">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title fw-300" id="endGameModalLabel">END GAME</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="text-align: center;">
				<p class="m-4" style="font-weight: bold; font-size: 16pt;">Are you sure you wish to end this game?</p>
			</div>
			<div class="modal-footer d-flex justify-content-between">
				<button type="button" class="btn text-secondary" data-dismiss="modal" style="width: 45%;">Cancel</button>
				<button type="button" class="btn text-danger" style="width: 45%;" ng-click="endGame()">End Game</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="changeGameModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="changeGameModalLabel" aria-hidden="true" style="color: #333;">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title fw-300" id="changeGameModalLabel">CHANGE GAME TYPE</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" >
				<div class="m-2">Current Game: {{game.type | uppercase}}.  <span class="ml-1" ng-if="game.type != activeGameType">Change type to: {{activeGameType | uppercase}}?</span></div>
				<div class="d-flex justify-content-between">
					<button class="btn " 
					ng-class="{'btn-dark':(activeGameType == 'bingo'), 'btn-outline-dark':(activeGameType != 'bingo')}" 
					style="width: 24%;" ng-click="setActiveGameType('bingo')">BINGO</button>
					<button class="btn " 
					ng-class="{'btn-dark':(activeGameType == 'X'), 'btn-outline-dark':(activeGameType != 'X')}"
					style="width: 24%;" ng-click="setActiveGameType('X')">X</button>
					<button class="btn " 
					ng-class="{'btn-dark':(activeGameType == 'window'), 'btn-outline-dark':(activeGameType != 'window')}"
					style="width: 24%;" ng-click="setActiveGameType('window')">WINDOW</button>
					<button class="btn " 
					ng-class="{'btn-dark':(activeGameType == 'blackout'), 'btn-outline-dark':(activeGameType != 'blackout')}"
					style="width: 24%;" ng-click="setActiveGameType('blackout')">BLACKOUT</button>
				</div>
			</div>
			<div class="modal-footer d-flex justify-content-between">
				<button type="button" class="btn text-secondary" data-dismiss="modal" style="width: 45%;">Cancel</button>
				<button type="button" class="btn text-warning" style="width: 45%;" ng-click="changeGame()">Change Game</button>
			</div>
		</div>
	</div>
</div>