<div class="container-fluid">
	<div class="panel panel-default" style="margin-top:5px;">
		<div class="panel-heading panel-head-color" style="height:49px;">
			
			<div class="panel-navbar">
				<ul>
					<li><span class="nav-span">Courses</span></li>
					<li><span class="nav-span">Peer Reviews</span></li>
					<li><span class="nav-span">Grades</span></li>
					<li><span class="nav-span">Feedback Submission</span></li>
					<li><span class="nav-span">Student Information</span></li>
				</ul>
			</div>
			
		</div>
		
		<div class="panel-body">
			<?php
				require_once('classes/canvasWrapper.php');
				$canvas = new CanvasWrapper();
				$canvas->formatUserData();
				$canvas->formatCourseData();
			?>
		</div>
	</div>
</div>
