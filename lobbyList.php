<div class="row m-2" ng-hide="game.active" >
	<div style="width: 100%;">
		<h3 class="d-flex justify-content-center" style="font-weight: lighter; color: #FF000066;">{{lobbyTitle}}</h3>
	</div>
	<div class="col">
		<div ng-repeat="user in lobby" class="list-group-flush" style="background-color: #00000000; background: none;">
			<div class="list-group-item" style="background-color: #00000000; background: none;  border-bottom: 1px solid #FF000033;">

				<div class="row " style="font-weight: lighter; font-size: 16pt; align-content: center;">

					<div class="col "> {{user.name}} <br></div>

					<span class="col " ng-if="user.name == activeUser.name">
						<button class="btn btn-outline-light m-2 " data-toggle="modal" data-target="#editCardModal">Card 1</button>
						<button class="btn btn-outline-light m-2 ">Card 2</button>
						<button class="btn btn-outline-light m-2 ">Card 3</button>
					</span>

				</div>

			</div>
		</div>
	</div>
</div>
<?php include 'cardModal.html'; ?>