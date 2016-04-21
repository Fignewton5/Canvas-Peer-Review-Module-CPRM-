<!-- Function to redirect after 3 seconds -->
<script type="text/javascript">
	function timedRedirect(){
		setTimeout(function(){
			window.location.href = "?controller=cprm&action=peerReviews";
		}, 3000) //redirect after 3 seconds
	}
</script>

<div class="container-fluid">
	<div class="panel panel-default" style="margin-top:5px;">
		<div class="panel-body">
		
		<?php
		
				//grant access to $_SESSION[]
				session_start();
				
				//arrays for storing form data (rubric rows)
				$criteria = array();
				$maxPoints = array();
			
				//extract rubric data from POST
				for($i = 0; $i < 10; $i++){
				
					if (isset($_POST['row' . $i . 'crit'])){
						//echo '<div>' . $_POST['row' . $i . 'crit'] . '</div>';
						//add criteria to array
						$criteria[] = $_POST['row' . $i . 'crit'];
					}
					if (isset($_POST['row' . $i . 'pts'])){
						//echo '<div>' . $_POST['row' . $i . 'pts'] . '</div>';
						//add max points to array
						$maxPoints[] =  $_POST['row' . $i . 'pts'];
					}
				} 
				
				//create empty peer reviews to be filled out by students
				//and send to database
				require_once("classes/dbInterface.php");
				$dbInt = new DbInterface();
				
				$dbInt->createReviews($criteria, $maxPoints, $_SESSION['course']->id, $_POST['rubricName']);
				
				echo '<div>Successfully created peer review!</div>';
				echo '<div> Navigating back to previous page in 3 seconds...</div>';
				
				echo '<script>timedRedirect();</script>';
				
			?>
		
		</div> <!-- panel-body -->
	</div> <!-- panel panel-default -->
</div> <!-- container-fluid -->