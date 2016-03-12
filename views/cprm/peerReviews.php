<?php
	//redirect to login if not logged in
	session_start();
	if (!isset($_SESSION['token'])) {
		header("Location: ?controller=account&action=login");
	}
	
	require_once('classes/dbInterface.php');
	$dbInt = new DbInterface();
	
	//if group number is set then update DB
	if (isset($_POST['groupNumber'])) {
		
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
								<button type='button' class='btn btn-default' onclick="addRowRubric()">Add Row</button>
								<button type='button' class='btn btn-default' onclick="removeRowRubric()">Remove Row</button>
							</div>
							<div class="col-md-5">
								<button type="submit" class="btn btn-default">Submit Rubric</button>
							</div>
						</div> <!-- button row -->
						
					</div> <!-- col-md-7 -->
				</form> <!-- rubric form -->
				
				<!-- this will be the group assign UI -->
				<div class="col-md-7" id="group-assign-table" style="display:none">
					GROUP ASSIGN
					<?php
						$users = $dbInt->getUsersForGroup($SESSION['course']->id);
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
											$i = 0;
											foreach ($users as $u) {
												echo "<tr>";
												echo "<td>" . $u['name'] . "</td>";
												echo "<td><input type='text' name='groupNumber" . $i . "' class='form-control' value='" . $u['groupNumber'] . "'></td>";
												echo "</tr>";
												$i++;
											}
											echo "<input type='hidden' name='users' value='" . $users . "'>";
											echo "<input type='hidden' name='count' value='" . $i . "'>";
										?>
									</tbody>
								</table>
							</form>
						}
					?>
				<div>
				
			</div> <!-- row -->
		</div> <!-- panel-body -->
	</div> <!-- panel panel-default -->
</div> <!-- container-fluid -->

<script type="text/javascript">

	//adds a criteria row to the rubric creation table
	function addRowRubric(){
	
		//first count how many rows are inside the rubric table
		//because our database only allows for 10 criteria per rubric
		var rowCount = $("#rubric-table-body > tr").length;
		
		//if less than 10 rows, add a new row
		if(rowCount < 10){
		
			//create <tr></tr> element
			var row = document.createElement("tr");
			//fill element with table row data
			var td1 = '<td><input type="text" class="form-control" value="" name="row' + rowCount + 'crit" required></td>';
			var td2 = '<td><input type="text" style="width:20%" class="form-control" value=""  name="row' + rowCount + 'pts" required></td>';
			var rowData = td1 + td2;
			row.innerHTML = rowData;
			
			//plug the row into the <tbody> 
			$("#rubric-table-body").append(row);
		}
		else alert("Maximum amount of rows reached! [10]");
	}
	
	//removes a criteria row from the rubric creation table
	function removeRowRubric(){
	
		//first count how many rows are inside the rubric table
		//so that we don't try to remove a row when we have 1 row
		var rowCount = $("#rubric-table-body > tr").length;
		
		//if more than 1 row, remove a row
		if(rowCount > 1){
			//remove the last row in the rubric table
			$("#rubric-table-body > tr:last").remove();
		}
		else alert("Can't remove first row!");
	}
	
	//displays the HTML for creating a rubric
	function createRubric(){
		$("#group-assign-table").hide();
		$("#rubric-table").show();
	}
	
	//displays the HTML for assigning a group
	function assignGroup(){
		$("#rubric-table").hide();
		$("#group-assign-table").show();
	}
</script>