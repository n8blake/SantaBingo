<div class="row m-2" ng-hide="game.active" style="position: relative; top: 100px; margin-top: 50px; margin-bottom: 20px;">
	<div style="width: 100%;">
		<h3 class="d-flex justify-content-center" style="font-weight: 300; color: #FF000066;">{{lobbyTitle}}</h3>
	</div>
	<div class="col">
		<div ng-repeat="user in lobby" class="list-group-flush" style="background-color: #00000000; background: none;">
			<div class="list-group-item" style="background-color: #00000000; background: none;  border-bottom: 1px solid #FF000033;">
				<div class="row " style="font-weight: 300; font-size: 16pt; align-content: center;">
					<div class="col "> {{user.name}} </div>
				<?php if($_SESSION['role'] == 'overlord' || $_SESSION['role'] == 'manager'){ ?>
				<button type="button" class="close text-dark m-1" ng-click="removeFromLobby(user)" >
		    		<span aria-hidden="true">&times;</span>
				</button>
				<?php }; ?>
				</div>

			</div>
		</div>
	</div>
	<div style="width: 100%; padding-bottom: 100px;"> </div>
</div>

<div class="row m-2" ng-show="game.active" style="position: relative; top: 100px; margin-top: 50px; margin-bottom: 20px;">
	<div class="col">
		<div >
			<h3 class="d-flex justify-content-center" style="font-weight: 300; color: #ADD9AA66;">PLAYERS</h3>
		</div>
		<div ng-repeat="user in players" class="list-group-flush" style="background-color: #00000000; background: none;">
			<div class="list-group-item" style="background-color: #00000000; background: none;  border-bottom: 1px solid #ADD9AA66; font-weight: 300; font-size: 16pt; ">
					{{user.name}}
				<?php if($_SESSION['role'] == 'overlord' || $_SESSION['role'] == 'manager'){ ?>
				<button type="button" class="close text-dark m-1" ng-click="setRemovingUser(user)" data-toggle="modal" data-target="#removeUserModal">
		    		<span aria-hidden="true">&times;</span>
				</button>
				<?php }; ?>
			</div>
		</div>
		
	</div>
	<div style="width: 100%; padding-bottom: 100px;"> </div>
</div>

<!-- Modal -->
<div class="modal fade" id="removeUserModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="removeUserModalLabel" aria-hidden="true" style="color: #333;">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title fw-300" id="removeUserModalLabel">REMOVE USER</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" style="text-align: center;">
				<p class="m-4" style="font-weight: bold; font-size: 16pt;">Are you sure you wish to remove {{removingUser.name}} game?</p>
			</div>
			<div class="modal-footer d-flex justify-content-between">
				<button type="button" class="btn text-secondary" data-dismiss="modal" style="width: 45%;">Cancel</button>
				<button type="button" class="btn text-danger" style="width: 45%;" ng-click="removePlayerFromGame()">Remove</button>
			</div>
		</div>
	</div>
</div>