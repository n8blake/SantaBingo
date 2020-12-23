<div class="row m-2" ng-hide="game.active" >
	<div style="width: 100%;">
		<h3 class="d-flex justify-content-center" style="font-weight: lighter; color: #FF000066;">{{lobbyTitle}}</h3>
	</div>
	<div class="col">
		<div ng-repeat="user in lobby" class="list-group-flush" style="background-color: #00000000; background: none;">
			<div class="list-group-item" style="background-color: #00000000; background: none;  border-bottom: 1px solid #FF000033;">

				<div class="row " style="font-weight: lighter; font-size: 16pt; align-content: center;">

					<div class="col "> {{user.name}} </div>

				</div>

			</div>
		</div>
	</div>
</div>

<div class="row m-2" ng-show="game.active" style="position: relative; top: 80px; margin-top: 50px; margin-bottom: 20px;">
	<div class="col">
		<div >
			<h3 class="d-flex justify-content-center" style="font-weight: lighter; color: #ADD9AA66;">PLAYERS</h3>
		</div>
		<div ng-repeat="user in players" class="list-group-flush" style="background-color: #00000000; background: none;">
			<div class="list-group-item" style="background-color: #00000000; background: none;  border-bottom: 1px solid #ADD9AA66; font-weight: lighter; font-size: 16pt; ">
					{{user.name}}
			</div>
		</div>
		<div style="width: 100%; padding-bottom: 40px;"> </div>
	</div>
</div>