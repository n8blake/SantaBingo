<div class="row m-2" ng-show="game.active" style="position: relative; top: 100px; margin-top: 50px; margin-bottom: 20px;">
	<div class="col">
		<div >
			<h3 class="d-flex justify-content-center lobbyTitle " ng-class="{'lobbyTitleActive':game.active}">PLAYERS</h3>
		</div>
		<div ng-repeat="user in players" class="list-group-flush" style="background-color: #00000000; background: none;">
			<div class="lobbyListItem" ng-class="{'lobbyListItemActive':game.active}">
					{{user.name}}
				<?php if($_SESSION['role'] == 'overlord' || $_SESSION['role'] == 'manager'){ ?>
				<button type="button" class="close text-light m-1" ng-click="removePlayerFromGame(user)" >
					<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-box-arrow-down" viewBox="0 0 16 16">
					  <path fill-rule="evenodd" d="M3.5 10a.5.5 0 0 1-.5-.5v-8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 0 0 1h2A1.5 1.5 0 0 0 14 9.5v-8A1.5 1.5 0 0 0 12.5 0h-9A1.5 1.5 0 0 0 2 1.5v8A1.5 1.5 0 0 0 3.5 11h2a.5.5 0 0 0 0-1h-2z"/>
					  <path fill-rule="evenodd" d="M7.646 15.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 14.293V5.5a.5.5 0 0 0-1 0v8.793l-2.146-2.147a.5.5 0 0 0-.708.708l3 3z"/>
					</svg>
		    		<!--<span aria-hidden="true">&times;</span>-->
				</button>
				<?php }; ?>
			</div>
		</div>
		
	</div>
	<div style="width: 100%; padding-bottom: 100px;"> </div>
</div>

<div class="row m-2" style="position: relative; top: 100px; margin-top: 50px; margin-bottom: 20px;" ng-show="lobby">
	<div style="width: 100%;">
		<h3 class="d-flex justify-content-center lobbyTitle" ng-class="{'lobbyTitleActive':game.active}">LOBBY</h3>
	</div>
	<div class="col">
		<div ng-repeat="user in lobby" class="list-group-flush" style="background-color: #00000000; background: none;">
			<div class="lobbyListItem" ng-class="{'lobbyListItemActive':game.active}">
				<div class="row  " >
					<div class="col "> {{user.name}} </div>
				<?php if($_SESSION['role'] == 'overlord' || $_SESSION['role'] == 'manager'){ ?>
				<button type="button" class="close text-light m-2 " ng-click="addUserToGame(user)" ng-show="game.active" style="position: relative; min-width: 40px; top: 4px;">
		    		<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-box-arrow-in-up" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M3.5 10a.5.5 0 0 1-.5-.5v-8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 0 0 1h2A1.5 1.5 0 0 0 14 9.5v-8A1.5 1.5 0 0 0 12.5 0h-9A1.5 1.5 0 0 0 2 1.5v8A1.5 1.5 0 0 0 3.5 11h2a.5.5 0 0 0 0-1h-2z"/>
  <path fill-rule="evenodd" d="M7.646 4.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V14.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3z"/>
</svg>
				</button>
				<button type="button" class="close text-light m-2" ng-click="removeFromLobby(user)" style="min-width: 40px;">
		    		<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
					  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
					</svg>
				</button>
				<?php }; ?>
				</div>

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