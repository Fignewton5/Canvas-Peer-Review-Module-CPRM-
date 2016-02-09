<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>CPRM</title>
  
  <!-- css -->
  
  <!-- bootstrap -->
  <link href="style/bootstrap.css" rel="stylesheet">
  
  <!-- local -->
  <link href="style/local.css" rel="stylesheet">
  
  <!-- fonts: roboto -->
  <link href='https://fonts.googleapis.com/css?family=Roboto:500' rel='stylesheet' type='text/css'>
  
  <!-- libraries -->
  
  <!-- jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  
  <!-- bootstrap -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  
  <!-- local, commented out until something is in it -->
  <script src="scripts/local.js"></script>
  
  <!-- navbar declaration -->
  <nav class="navbar navbar-default">
  	<div class="container-fluid">
  		<div class="navbar-header">
  			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
  			 data-target=".navbar-collapse">
  				<span class="sr-only">Toggle navigation</span>
  				<span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
  			</button>
  			<a class="navbar-brand" href="?controller=cprm&action=home">CPRM</a>
  		</div>
  		
  		<div class="navbar-collapse collapse" id="navbar-options">
  			<ul class="nav navbar-nav">
  				<li id='courses'><a href="?controller=cprm&action=home">Courses</a></li>
  				<li id='peerReviews'><a href="#">Peer Reviews</a></li>
  				<li id='grades'><a href="?controller=cprm&action=grades">Grades</a></li>
  				<li id='feedbackSubmission'><a href="?controller=cprm&action=feedback">Feedback Submission</a></li>
  				<li id='logout' style="float:right;"><a href="?controller=cprm&action=logout">Logout</a></li>
  			</ul>
  			
  		</div>
  		
  	</div>
  </nav>
  
</head>
<body>
	<?php require_once('routes.php'); ?>
</body>

<script src="scripts/eventHandlers.js"></script>
</html>