<?php
	//check to see if session has been reset
	session_start();
	
	//make sure to grab a copy of the user's id
	//if not set already
	if (!isset($_SESSION['user_id'])){
		require_once('classes/canvasWrapper.php');
		
		//create a new canvas wrapper class to grab the user info
		$canvas = new CanvasWrapper();
		$data = $canvas->formatUserData;
		
		//set user_id session variable for later use
		$_SESSION['user_id'] = $data->user_id;
	}
	
	if (!isset($_SESSION['token'])) {
		header("Location: ?controller=account&action=login");
	}

	//check / set course information in session

	if (isset($_POST['course'])) {
		require_once('classes/canvasWrapper.php');
		$canvas = new CanvasWrapper();
		$courses = $canvas->formatCourseData();
		foreach ($courses as $course) {
			if ($course->id == $_POST['course']) {
			
			//set course session to current course selected
			$_SESSION['course'] = $course;
			
			//after it is set go to give feedback
			header('Location: ?controller=cprm&action=feedback');
			}
		}
	}

?>
<div class="container-fluid">
	<div class="panel panel-default" style="margin-top:5px;">
		<div id="userIdPanel" class="panel-heading" style="height:49px;">
			<?php
				//this is a user greeting
				if (isset($_SESSION['token'])) {
					require_once('classes/canvasWrapper.php');
					$canvas = new CanvasWrapper();
					$canvas->printUserName();
				} 
			?>
		</div>
		
		<div class="panel-body" id="test">
			
			<!-- instantiate courses here -->
 			<form action="?controller=cprm&action=home" method="post">
	  			<?php
		  			
		  			if (isset($_SESSION['token'])) {
		  				require_once('classes/canvasWrapper.php');
						$canvas = new CanvasWrapper();
						$canvas->createCourseButtons();
		  			}
				?>
			</form>
		</div>
		
	</div>
</div>
