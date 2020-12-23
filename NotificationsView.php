<div ng-controller="NotificationCtrl" style="width: 100%; text-align: center;">
	<p>{{game.status}}</p>
	<!-- notification modal -->
	<div class="modal fade" id="notificationModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="notificationLabel" aria-hidden="true" style="color: #333;">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="notificationModalLabel">
					{{notification.title}}
				</h5>
				
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" >
				<div ng-if="notification.type == 'win'">
					<h2 ng-repeat="winner in notification.winners"><strong class="text-success">{{winner.name}} just got SANTA<span ng-if="winner.bingoCount > 1"> {{winner.bingoCount}} times</span>!</strong></h2>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn text-secondary" style="width: 100%;" data-dismiss="modal" ng-click="readNotifications()">DONE</button>
			</div>
		</div>
	</div>
	</div>
</div>