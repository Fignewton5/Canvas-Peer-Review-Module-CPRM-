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
								echo '<div>OSU ID: ' . $osuID . '</div>';
							}
							else echo '<div>ERROR GETTING OSUID</div>';
							
							//use database interface to grab all reviews for the current user AND in the current course
							//$query = "SELECT * FROM review WHERE reviewFor='" . $osuID . "' AND forClass='" . $_SESSION['course']->id . "'";
							$grades = $dbInt->getStudentGrades($osuID, $_SESSION['course']->id);
							if($grades != FALSE){
								foreach($grades as $row){
									echo '<tr>';
									echo '	<td>' . $row['reviewName'] . '</td>';
									echo '	<td>' . $row['pEarn0'] . '</td>';
									echo '	<td>' . $row['pEarn1'] . '</td>';
									echo '	<td>' . $row['pEarn2'] . '</td>';
									echo '	<td>' . $row['pEarn3'] . '</td>';
									echo '	<td>' . $row['pEarn4'] . '</td>';
									echo '	<td>' . $row['pEarn5'] . '</td>';
									echo '	<td>' . $row['pEarn6'] . '</td>';
									echo '	<td>' . $row['pEarn7'] . '</td>';
									echo '	<td>' . $row['pEarn8'] . '</td>';
									echo '	<td>' . $row['pEarn9'] . '</td>';
									//sum up totals
									echo '	<td>' . ($row['pEarn0'] + $row['pEarn1'] + $row['pEarn2'] 
															+ $row['pEarn3'] + $row['pEarn4'] + $row['pEarn5'] 
															+ $row['pEarn6'] + $row['pEarn7'] + $row['pEarn8'] 
															+ $row['pEarn9']) . '</td>';
									echo '</tr>';
								}
							}
							else echo 'No grades found for current student.';
							
							
						?>
				
					</tbody>
				</table>
			
				<!-- Button to test loading table rows -->
				<br></br>
				<div class="container">
					<button type="button" class="btn-default" id="load-grades" onclick="loadGradesStudent()">Fetch Grades [TEST]</button>
				</div>
			</div>
		</div>

	<?php elseif(($enrollment == "teacher") or ($enrollment == "ta")) : ?>
	
		<!-- Instructor View -->
		<div class="panel panel-default" style="margin-top:5px;" id="profView">
			<div class="panel-body">
				<!-- Search Bar -->
				<div class="row" style="width:800px; margin-left:0.5cm">
						<label for="gradesSearch"> Search </label>
						<input type="text" class="form-control" id="gradesSearch" placeholder="Student">
				</div>
				
				<br></br>
				
				<!-- Import / Export Buttons -->
				<div class="row" style="width:800px; margin-left:0.5cm">
					<button type="button" class="btn-default" id="importGrades">Import</button>
					<button type="button" class="btn-default" id="exportGrades">Export</button>
				</div>

				<br></br>
				
				<!-- Table in which grades data will be displayed -->
				<h2>Class Grades</h2>
				<table class="table-bordered" style="width:800px">
					<thead>
						<tr>
							<th>Student Name</th>
							<th>Student ID</th>
							<th>Peer Eval 1</th>
							<th>Peer Eval 2</th>
							<th>Peer Eval 3</th>
							<th>Peer Eval 4</th>
						</tr>
					</thead>
					
					<tbody id="grades-table-body-professor">
					
					</tbody>
				</table>
					
				<!-- Button to test loading table rows -->
				<br></br>
				<div class="container">
					<button type="button" class="btn-default" id="load-grades" onclick="loadGradesProf()">Fetch Grades [TEST]</button>
				</div>
			</div>	
		</div>
	
	<?php endif; ?>
	
	

	<!-- 	Buttons for demo video purposes 
			Toggles profView or studentView 
			divs to reflect either what a professor
			would see, or what a student would see.
	
	<button type="button" class="btn-default" onClick="showProfessorGrades()">Professor View</button>
	<button type="button" class="btn-default" onClick="showStudentGrades()">Student View</button>
	<br></br>-->

	
</div>


