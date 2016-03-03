<?php
	//check to see if session has been reset
	session_start();
	
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
			
			//I don't think this is needed
			//header('Location: ?controller=cprm&action=feedback');
			}
		}
	}

?>
<div class="container-fluid">
	<div class="panel panel-default" style="margin-top:5px;">
		<div id="userIdPanel" class="panel-heading" style="height:49px;">
			<p style='font-size:18px;'>
				<?php
					//this is a user greeting
					if (!isset($_SESSION['course']) && isset($_SESSION['token'])) {
						require_once('classes/canvasWrapper.php');
						$canvas = new CanvasWrapper();
						$canvas->printUserName();
						echo "To start select a course from below.";
					}
					if (isset($_SESSION['course'])) {
						$canvas->printUserName();
						echo " Current active course: " . $_SESSION['course']->courseName;
					} 
				?>
			</p>
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
