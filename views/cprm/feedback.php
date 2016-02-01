<div class="container-fluid remove-paddingLR">
	<div class="row" style="margin-top:15px;">
		<div class="col-md-4" style="float:left;">
			<div class="feedback-side-menu">
				<div style="padding-bottom:2px;">
					<button type="button" class="btn btn-default feedback-button-fixes" id="single">
						Single Reviews
					</button>
				</div>
				<div style="padding-top:2px;">
					<button type="button" class="btn btn-default feedback-button-fixes" id="group">
						Group Reviews
					</button>
				</div>
			</div>
		</div>
		<?php
			// require_once('connection.php'); 
			// $db = Db::getInstance();
			// $result = $db->query("SELECT * FROM Test WHERE reviewName='cs462'");
			// while ($row = mysqli_fetch_array($result)) {
				// echo $row['reviewName'] . " " . $row['pointMax'] . $row['field1'] . $row['pointFor1'];
			// }
		?>
		<div class="col-md-8" style="float:left;width:80%;">
			<div style="width:100%;">
				<table class="table table-striped table-condensed">
					<thead>
						<tr>
							<th>Evaluation Criteria</th>
							<th>Points Possible</th>
							<th>Points Earned</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td class="feedback-tb-top-padding">Sample Presentation</td>
							<td class="feedback-tb-top-padding">5 Points</td>
							<td><input type='text' style="width:20%;" class='form-control' /></td>	
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
