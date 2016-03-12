<?php
	function call($controller, $action) {
		
		// require the file that matches the controller name (cprm_controller.php)
		require_once('controllers/' . $controller . '_controller.php');
		
		// instantiate new instance of needed controller
		switch($controller) {
			case 'cprm':
				$controller = new CprmController();
				break;
			
			case 'account':
				$controller = new AccountController();
				break;
		}
		
		// call the action
		$controller->{ $action }();
	}
	
	// create a list of the controllers we have and their actions
	$controllers = array('cprm' => ['home', 'error', 'feedback', 'grades', 'logout', 'peerReviews', 'submitRubric'], 'account' => ['login']);
	
	// check that the requested controller and action are both allowed
	// if someone tries to access something else he will be redirected to the error action of the pages controller
	if (array_key_exists($controller, $controllers)) {
		if(in_array($action, $controllers[$controller])) {
			call($controller, $action);
		}
		else {
			call('cprm','error');
		}
	}
	else {
		call('cprm','error');
	}
?>