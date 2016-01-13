<?php
	function call($controller, $action) {
		require_once('controllers/' . $controller . '_controller.php');
		
		switch($controller) {
			case 'cprm':
				$controller = new CprmController();
			break;
		}
		
		$controller->{ $action }();
	}
	
	$controllers = array('cprm' => ['home', 'error']);
	
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