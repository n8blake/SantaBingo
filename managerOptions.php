<button class="btn btn-block btn-outline-light m-2 ml-n1" ng-hide="game.active" ng-click="startGame()" style="position: relative; top: 45%; margin-bottom: 30px;">
	<strong>start a game</strong>
</button>

<div style="margin-top: 40px;" ng-show="game.active" class="ml-n2">
	<button class="btn btn-block btn-outline-light m-2 "  ng-click="nextNumber()" style="z-index: 10;">
		<strong>next card</strong>
	</button>
	<button class="btn btn-block btn-outline-secondary m-2 "
	class="btn btn-primary" data-toggle="modal" data-target="#endGameModal" style="z-index: 10;">
		<strong>end game</strong>
	</button>
</div>
<!-- Modal -->
<div class="modal fade" id="endGameModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="endGameModalLabel" aria-hidden="true" style="color: #333;">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="endGameModalLabel">END GAME</h5>
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