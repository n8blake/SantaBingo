<div class="btn btn-block btn-outline-light m-2 " ng-hide="game.active">
		<h2 ng-click="startGame()">start a game</h2>
</div>



<div class="btn btn-block btn-outline-light m-2 " ng-show="game.active">
		<h2 ng-click="nextNumber()">next card</h2>
</div>
<div class="btn btn-block btn-outline-secondary m-2 " ng-show="game.active"
class="btn btn-primary" data-toggle="modal" data-target="#endGameModal">
		<h2>end game</h2>
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