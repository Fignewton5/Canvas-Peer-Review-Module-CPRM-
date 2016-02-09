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
			if ($course->id == $_POST['course']) {}
			
			//set course session to current course selected
			$_SESSION['course'] = $course;
		}
		print_r($_SESSION['course']);
	}

?>
<div class="container-fluid">
	<div class="panel panel-default" style="margin-top:5px;">
		<div id="userIdPanel" class="panel-heading" style="height:49px;">
			<?php
				if (isset($_SESSION['token'])) {
					require_once('classes/canvasWrapper.php');
					$canvas = new CanvasWrapper();
					$canvas->printUserName();
				} 
			?>
			
			<!-- <div class="panel-navbar">
				<ul>
					<li><span class="nav-span">Courses</span></li>
					<li><span class="nav-span">Peer Reviews</span></li>
					<li><span class="nav-span" id="grades">Grades</span></li>
					<li><span class="nav-span">Feedback Submission</span></li>
					<li><span class="nav-span">Student Information</span></li>
				</ul>
			</div> -->
			
			
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
