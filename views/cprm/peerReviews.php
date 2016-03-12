<?php
	//redirect to login if not logged in
	session_start();
	if (!isset($_SESSION['token'])) {
		header("Location: ?controller=account&action=login");
	}
	
	require_once('classes/dbInterface.php');
	$dbInt = new DbInterface();
	
	//if group number is set then update DB
	if (isset($_POST['users'])) {
		$groupNumArr = array();
		for ($i = 0; $i < $_POST['count']; $i++) {
			$groupNumArr[] = $_POST['groupNumber' . $i];
		}
		$dbInt->addUserGroup($_POST['users'], $groupNumArr);
	}
?>

<div class="container-fluid">
	<div class="panel panel-default" style="margin-top:5px;">
		<div class="panel-body">	
			<div class="row" style="margin-top:15px;">
				<div class="col-md-3" style="float:left;">
					<div class="peerReview-side-menu">
						<div style="padding-bottom:2px;">
							<button type="button" class="btn btn-default feedback-button-fixes" id="single" onclick="createRubric()">Create Rubric</button>
						</div>
						<div style="padding-top:2px;">
							<button type="button" class="btn btn-default feedback-button-fixes" id="group" onclick="assignGroup()">Assign Group</button>
						</div>
					</div> <!-- peerReview-side-menu -->
				</div> <!-- col-md-3 -->
				
				<!-- This will be the rubric table 
						The actual database query is performed by
						a script on the submitRubric page.
				-->
				<form action="?controller=cprm&action=submitRubric" method="post" id="rubric-table">
					<div class="col-md-7" style="float:left;">
						<div style="width:100%;" id="rubric-container">
							<table class="table table-striped table-condensed">
								<thead>
									<tr>
										<th>Evaluation Criteria</th>
										<th>Points Possible</th>
									</tr>
								</thead>
								
								<!-- rubric content goes here (criteria) 
										require at least one row so that
										an empty form can't be submitted
								-->
								<tbody id="rubric-table-body">
									<tr>
										<td><input type="text" class="form-control" value="" name="row0crit" required></td>
										<td><input type="text" class="form-control" value="" name="row0pts" style="width:20%" required></td>
									</tr>
								</tbody>
							</table> <!-- rubric table -->
						</div> <!-- div (rubric-container) -->
						
						<!-- Buttons that will add or remove rows from the rubric -->
						<div class="col-md-12">
							<div class="col-md-5">
								<button type='button' class='btn btn-default' onclick="addRowRubric();">Add Row</button>
								<button type='button' class='btn btn-default' onclick="removeRowRubric();">Remove Row</button>
							</div>
							<div class="col-md-5">
								<button type="submit" class="btn btn-default">Submit Rubric</button>
							</div>
						</div> <!-- button row -->
						
					</div> <!-- col-md-7 -->
				</form> <!-- rubric form -->
				
				<!-- this will be the group assign UI -->
				<div class="col-md-7" id="group-assign-table" style="display:none">
					<?php
						//print_r($_SESSION['course']);
						$users = $dbInt->getUsersForGroup($_SESSION['course']->id);

						if (count($users) > 0) { ?>
							<form action='?controller=cprm&action=peerReviews' method='post'>
								<table class='table table-striped table-condensed'>
									<thead>
										<tr>
											<th>Name</th>
											<th>Group Number</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$i = 1;
											foreach ($users as $u) {
												echo "<tr>";
												echo "<td>" . $u['name'] . "</td>";
												echo "<td><input type='text' name='groupNumber" . $i . "' style='width:10%;' class='form-control' value='" . $u['groupNumber'] . "'></td>";
												echo "</tr>";
												$i++;
											}
											echo "<input type='hidden' name='users' value='" . $users . "'>";
											echo "<input type='hidden' name='count' value='" . $i . "'>";
										?>
									</tbody>
								</table>
								<button type="submit" name="submit" style="float:right;" class="btn btn-default">Submit</button>
							</form>
				<?php }	?>
				<div>
				
			</div> <!-- row -->
		</div> <!-- panel-body -->
	</div> <!-- panel panel-default -->
</div> <!-- container-fluid -->