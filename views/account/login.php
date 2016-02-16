<?php

	//initialization of session and DB
	session_start();
	$db = Db::getInstance();
	
	if (isset($_POST['token'])) {
		$_SESSION['token'] = $_POST['token'];

		require_once('classes/canvasWrapper.php');
		$c = new CanvasWrapper();
		if ($c->testToken()) {
			//send user to home page or add the user or whatever
			require_once('classes/dbInterface.php');
			$dbInt = new DbInterface();
			
			//check if user has been added to the db first
			if (!$dbInt->checkUserToken($_POST['token'])) {
				//add user to db
				$dbInt->addUserToDb($_POST['token']);
				
				//also add osu id to session
				$user = $c->formatUserData();
				$_SESSION['id'] = $user->user_id;
			}
			
			//redirect after successful addition
			header('Location: http://cprmphp-weavex.rhcloud.com/?controller=cprm&action=home');

		}
		else {
			echo "Invalid Token Entered. Try Again<br><br>";
		}
	}
	
	if (isset($_POST['osuId'])) {
		//sql lookup to get user info from Id.
		$sql = "SELECT * FROM users WHERE osuId=" . $_POST['osuId'];
		$result = $db->query($sql);
		
		//run a fetch to see if the query was empty
		$row = $result->fetch();
		if (!$row) {
			echo "User not registered or invalid token entered.<br><br>";
		}
		
		//add token data to session
		else {
			$_SESSION['id'] = $_POST['osuId'];
			$_SESSION['token'] = $row['token'];
			header('Location: http://cprmphp-weavex.rhcloud.com/?controller=cprm&action=home');
		}	
		
	}

?>
<div class="container-fluid">
	<div class="panel panel-default" style="margin-top:5px;">
		<div id="userIdPanel" class="panel-heading" style="height:49px;">
			<p>Welcome. To begin using this service, please enter your token.
			If you have registered already, you may just enter your OSU ID Number.</p>
		</div>
		
		<div class="panel-body" id="test">
			<form action="?controller=account&action=login" method="post">
				<div class='col-md-6'>
					<div class='input-group'>
						<input type='text' class='form-control' name='token' placeholder='Token' />
						<span class='input-group-btn'>
							<button class='btn btn-secondary' type='submit'>Submit</button>
						</span>
					</div>
				</div>
				<div class='col-md-6'>
					<div class='input-group'>
						<input type='text' class='form-control' name='osuId' placeholder='OSU ID' />
						<span class='input-group-btn'>
							<button class='btn btn-secondary' type='submit'>Submit</button>
						</span>
					</div>
				</div>
				
			</form>
		</div>
		
	</div>
</div>
