<?php
	//redirect to login if not logged in
	session_start();
	if (!isset($_SESSION['token'])) {
		header("Location: ?controller=account&action=login");
	}
?>

<!-- This will be the grades table that shows the students' grades -->
<div class="container-fluid">

	<?php
	
	//grant access to wrapper to check user enrollment status
	require_once('classes/canvasWrapper.php');
	$wrapper = new CanvasWrapper();
	$enrollment = $wrapper->checkEnrollment();
	//for testing teacher view
	$enrollment = "teacher";
	
	//if a student name was entered into the search bar
	if (isset($_POST['searchName'])){
		//toggle on bool to signify that a student has been searched for
		$searchUsed = 1;
	}
	else $searchUsed = 0;
	
	?>
	
	
	<!--
		display the appropriate html depending on user enrollment
		alternate if statement syntax used here to avoid nasty javascript calls 
	-->
	<?php if($enrollment == "student") : ?>
	
		<!-- Student View -->
		<div class="panel panel-default" style="margin-top:5px;" id="studentView">
			<div class="panel-body">
				<h2>Student Grades</h2>
				<table class="table-bordered" style="width:800px; overflow:auto;">
					<thead>
						<tr>
							<th>Description</th>
							<th>Criteria 1</th>
							<th>Criteria 2</th>
							<th>Criteria 3</th>
							<th>Criteria 4</th>
							<th>Criteria 5</th>
							<th>Criteria 6</th>
							<th>Criteria 7</th>
							<th>Criteria 8</th>
							<th>Criteria 9</th>
							<th>Criteria 10</th>
							<th>Total</th>
						</tr>
					</thead>
				
					<tbody id="grades-table-body-student">
					
						<!-- Use PHP and MySQL queries here to fetch grades for student -->
						<?php
							
							//instantiate a database interface class object
							require_once('classes/dbInterface.php');
							$dbInt = new DbInterface();
							
							//use database interface to grab user's OSU ID using their token
							$osuID = $dbInt->getIDFromToken($_SESSION['token']);
							if($osuID != FALSE){
								//echo '<div>OSU ID: ' . $osuID . '</div>';
								//do nothing
							}
							else echo '<div>ERROR GETTING OSUID</div>';
							
							//use database interface to grab all reviews for the current user AND in the current course
							//$query = "SELECT * FROM review WHERE reviewFor='" . $osuID . "' AND forClass='" . $_SESSION['course']->id . "'";
							$grades = $dbInt->getStudentGrades($osuID, $_SESSION['course']->id);
							if($grades != FALSE){
								foreach($grades as $row){
									echo '<tr>';
									echo '	<td>' . $row['reviewName'] . '</td>';
									echo '	<td>' . $row['pEarn0'] . ' / ' . $row['pMax0'] . '</td>';
									echo '	<td>' . $row['pEarn1'] . ' / ' . $row['pMax1'] . '</td>';
									echo '	<td>' . $row['pEarn2'] . ' / ' . $row['pMax2'] . '</td>';
									echo '	<td>' . $row['pEarn3'] . ' / ' . $row['pMax3'] . '</td>';
									echo '	<td>' . $row['pEarn4'] . ' / ' . $row['pMax4'] . '</td>';
									echo '	<td>' . $row['pEarn5'] . ' / ' . $row['pMax5'] . '</td>';
									echo '	<td>' . $row['pEarn6'] . ' / ' . $row['pMax6'] . '</td>';
									echo '	<td>' . $row['pEarn7'] . ' / ' . $row['pMax7'] . '</td>';
									echo '	<td>' . $row['pEarn8'] . ' / ' . $row['pMax8'] . '</td>';
									echo '	<td>' . $row['pEarn9'] . ' / ' . $row['pMax9'] . '</td>';
									//sum up totals
									echo '	<td>' . ($row['pEarn0'] + $row['pEarn1'] + $row['pEarn2'] 
															+ $row['pEarn3'] + $row['pEarn4'] + $row['pEarn5'] 
															+ $row['pEarn6'] + $row['pEarn7'] + $row['pEarn8'] 
															+ $row['pEarn9']) 
															. ' / ' .
															($row['pMax0'] + $row['pMax1'] + $row['pMax2'] 
															+ $row['pMax3'] + $row['pMax4'] + $row['pMax5'] 
															+ $row['pMax6'] + $row['pMax7'] + $row['pMax8'] 
															+ $row['pMax9']). '</td>';
									echo '</tr>';
								}
							}
							else echo 'No grades found for current student.';
							
							
						?>
				
					</tbody>
				</table>
			
			</div> <!-- panel-body -->
		</div> <!-- panel panel-default -->

	<?php elseif(($enrollment == "teacher") or ($enrollment == "ta")) : ?>
	
		<!-- Instructor View -->
		<div class="panel panel-default" style="margin-top:5px;" id="profView">
			<div class="panel-body">
				
				<!-- Search Bar -->
				<form action="?controller=cprm&action=grades" method="post">
					<div class="input-group" style="width:40%">
						<input type="text" class="form-control" name="searchName" placeholder="Student Name...">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit">Search</button>
						</span> <!-- input-group-btn -->
					</div> <!-- input-group -->
				</form> <!-- Search bar form -->
				
				<?php
					//if a name was searched for then generate html to let
					//the user know what the original search was for
					if($searchUsed){
						echo '<br>';
						echo '<div>Displaying Results for ... ' . $_POST['searchName'] . '</div>';
					}
				?>
				
				<br><br>
				
				<!-- Table in which grades data will be displayed -->
				<h2>Class Grades</h2>
				<div>
				<?php $_SESSION['course']->id = 2147483647; echo  $_SESSION['course']->id; ?>
				</div>
				<table class="table-bordered" style="width:800px">
					<thead>
						<tr>
							<th>Student Name</th>
							<th>Student ID</th>
							<th>Peer Review</th>
							<th>For</th>
							<th>Score</th>
						</tr>
					</thead>
					
					<tbody id="grades-table-body-professor">
					
						<?php
								
							//if a search was not used, load all grades for class
							if(!$searchUsed){
								//instantiate a database interface class object
								require_once('classes/dbInterface.php');
								$dbInt = new DbInterface();
								
								//use database interface to grab all peer reviews recorded
								//for the currently active course
								$classGrades = $dbInt->getClassGrades($_SESSION['course']->id);
								
								//iterate through each peer review and display it in the table
								if($classGrades != FALSE){
									foreach($classGrades as $row){
									
										//grab the student's ID who performed the review
										$osuIdBy = $row['reviewBy'];
										//grab the student's ID who the review was performed for
										$osuIdFor = $row['reviewFor'];
										//use ID's to grab students' names
										$nameBy = $dbInt->getNameFromID($osuIdBy);
										$nameFor = $dbInt->getNameFromID($osuIdFor);
										
										//tally up score
										$scoreEarned = 0;
										$scorePossible = 0;
										for($i = 0; $i < $row['fieldsUsed']; $i++){
											$scoreEarned += $row['pEarn' . $i];
											$scorePossible += $row['pMax' . $i];
										}
										
										//generate HTML to fill out table
										//(name, id, review name, for, score)
										echo '<tr>';
										echo '	<td>' . $nameBy . '</td>';
										echo '	<td>' . $osuIdBy . '</td>';
										echo '	<td>' . $row['reviewName'] . '</td>';
										echo '	<td>' . $nameFor . '</td>';
										echo '	<td>' . $scoreEarned . ' / ' . $scorePossible . '</td>';
										echo '</tr>';
										
									} //foreach
								} //if
								//query failed
								else echo 'No grades found for current class.';
							}//if $searchUsed
							
							//else, load grades only for the searched student
							else{
								
								//instantiate instance of database interface object
								require_once('classes/dbInterface.php');
								$dbInt = new DbInterface();
								
								//use database interface to grab student's OSU ID using name
								$osuID = $dbInt->getIDFromName($_POST['searchName']);
								//echo '<div> OSU ID: ' . $osuID . '</div>';
								//echo '<div> COURSE ID: ' . $_SESSION['course']->id . '</div>';
								
								//use database interface to grab all peer reviews recorded
								//for the student that was searched for
								$searchStudentGrades = $dbInt->getSearchGrades($osuID, $_SESSION['course']->id);
								
								//iterate through the student's recorded peer reviews
								//and display them in the table
								foreach($searchStudentGrades as $row){
								
									//grab the student's ID who performed the review
									$osuIdBy = $row['reviewBy'];
									//grab the student's ID who the review was performed for
									$osuIdFor = $row['reviewFor'];
									//use ID's to grab students' names
									$nameBy = $dbInt->getNameFromID($osuIdBy);
									$nameFor = $dbInt->getNameFromID($osuIdFor);
									
									//tally up score
									$scoreEarned = 0;
									$scorePossible = 0;
									for($i = 0; $i < $row['fieldsUsed']; $i++){
										$scoreEarned += $row['pEarn' . $i];
										$scorePossible += $row['pMax' . $i];
									}
									
									//generate HTML to fill out table
									//(name, id, review name, for, score)
									echo '<tr>';
									echo '	<td>' . $nameBy . '</td>';
									echo '	<td>' . $osuIdBy . '</td>';
									echo '	<td>' . $row['reviewName'] . '</td>';
									echo '	<td>' . $nameFor . '</td>';
									echo '	<td>' . $scoreEarned . ' / ' . $scorePossible . '</td>';
									echo '</tr>';
								
								} //foreach
								
							}//else
							
						?>
					
					</tbody>
				</table>

				<br><br>
				
				<!-- Export Button -->
				<div class="row" style="width:800px; margin-left:0.0cm"> 
					<div class="col-md-5">
						<form  action="?controller=cprm&action=exportGrades" method="post">
							<button type="submit" class="btn btn-default" name="exportGrades" data-toggle="tooltip" title="Download Grades as CSV File">Export Grades</button>
						</form>
					</div>
				</div>
				
			</div>	<!-- panel-body -->
		</div> <!-- panel panel-default -->
	
	<?php endif; ?>
	
	<!-- enable javascript tooltips -->
	<script>
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();
		});
	</script>
	
</div> <!-- container-fluid -->


