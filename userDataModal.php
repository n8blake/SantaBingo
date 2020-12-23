<div class="modal fade" id="userDataModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="userDataModalLabel" aria-hidden="true" style="color: #333;">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="userDataModalLabel">
					<div>User Data</div>
				</h5>
				
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" >
				<p>Email: <?php echo($_SESSION['email']);?></p>
				<p>Role: <?php  echo($_SESSION['role']);?></p>
			</div>
			<div class="modal-footer d-flex justify-content-between">
				<a type="button" class="btn text-warning" ng-click="replaceCard(cards.indexOf(activeCard))" style="width: 45%;" href="logout.php">LOGOUT</a>
				<button type="button" class="btn text-secondary" style="width: 45%;" data-dismiss="modal" >DONE</button>
			</div>
		</div>
	</div>
</div>