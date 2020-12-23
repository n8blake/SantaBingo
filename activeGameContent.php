<div ng-controller="GameCtrl" class="row">
	<div class="col-md-6" ng-show="game.active || (activeUser.role == 'manager') || (activeUser.role == 'overlord')" style="min-height: 100px;">
	<div ng-show="game.active" >
	<div class="d-flex justify-content-center m-2 fw-300" style="color: #FFFFFF66;" ng-hide="calledNumbersListShow">
		<p>LAST CARD</p>
	</div>
	<div class="d-flex justify-content-center m-2" >
		
		<div class="card" style="background-color: #FFF; width: 300px; height: 300px; right: -5px;" ng-hide="calledNumbersListShow">
			<div class="card-body">
				<h5 class="card-title" style="font-family: Lato; font-weight: bolder; font-size: 32px;">{{game.lastNumber | letterForNumber}}
					<button type="button" class="close" ng-click="calledNumbersListShow = !calledNumbersListShow">
						<span aria-hidden="true">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-ol" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5z"/>
  <path d="M1.713 11.865v-.474H2c.217 0 .363-.137.363-.317 0-.185-.158-.31-.361-.31-.223 0-.367.152-.373.31h-.59c.016-.467.373-.787.986-.787.588-.002.954.291.957.703a.595.595 0 0 1-.492.594v.033a.615.615 0 0 1 .569.631c.003.533-.502.8-1.051.8-.656 0-1-.37-1.008-.794h.582c.008.178.186.306.422.309.254 0 .424-.145.422-.35-.002-.195-.155-.348-.414-.348h-.3zm-.004-4.699h-.604v-.035c0-.408.295-.844.958-.844.583 0 .96.326.96.756 0 .389-.257.617-.476.848l-.537.572v.03h1.054V9H1.143v-.395l.957-.99c.138-.142.293-.304.293-.508 0-.18-.147-.32-.342-.32a.33.33 0 0 0-.342.338v.041zM2.564 5h-.635V2.924h-.031l-.598.42v-.567l.629-.443h.635V5z"/>
</svg>
						</span>
					</button>
				</h5>

				<div class="d-flex justify-content-center" >
					<img style="position: relative; width: 100%; height: 100%; margin: 10px; top: -40px;" ng-src="./SVG/{{game.lastNumber}}.svg">
				</div>
				
			</div>
		</div>
		<div class="card" style="background-color: #FFF; width: 300px; right: -5px; margin-top: 11px;" ng-show="calledNumbersListShow">
			<div class="card-body">
				<h5 class="card-title" style="font-family: Lato; font-weight: bolder; font-size: 16px;">Called Cards
					<button type="button" class="close" ng-click="calledNumbersListShow = !calledNumbersListShow">
						<span aria-hidden="true">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-square-fill" viewBox="0 0 16 16">
  <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2z"/>
</svg>
						</span>
					</button>
				</h5>
				<div class="list-group-flush" style="max-height: 300px; overflow-y: auto;">
					<div class="list-group-item" style="border-top: solid; border-width: 0.5px; border-color: #DDD; " ng-repeat="number in game.calledNumbers | orderBy:'calledNumbers':reverse">
						<div class="d-flex justify-content-between" >
							<div style="font-weight: bolder; font-size: 32px; margin-left: 30px;">{{number | letterForNumber}}</div>
							<img style="width: 25%; height: 25%; margin-right: 30px;" ng-src="./SVG/{{number}}.svg">	
						</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>

	<?php 
		if($_SESSION['role'] == 'overlord' || $_SESSION['role'] == 'manager'){
			include 'managerOptions.php';
		};
	?>
	</div>
	
		<div class="col" style="margin-top: 20px;">
		
		<div style="width: 100%; height: 100%; max-width: 500px; background-color: #FFF; color: #000; padding: 20px; margin: auto; border-radius: 0.5em;" ng-include="'bingoCardTable.html'"></div>
		<div class="d-flex justify-content-between" style="max-width: 300px; margin: auto;">
			<button class="btn m-2 " ng-repeat="card in cards" 
			ng-class="{'btn-outline-light':(activeCard == card), 'text-secondary':(card != activeCard)}"
			ng-click="showCard(card)" style=" border-width: 0.5px;">
				CARD {{cards.indexOf(card) + 1}}
			</button>
		</div>
		<div class="d-flex justify-content-center">
			<button class="btn btn-outline-secondary" data-toggle="modal" data-target="#editCardModal" ng-if="!game.active">GET NEW CARD</button>
		</div>
		<?php include 'editCardModal.html'; ?>
	</div>
	
</div>