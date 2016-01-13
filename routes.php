<?php
	function call($controller, $action) {
		require_once('controllers/' . $controller . '_controller.php');
		
		switch($controller) {
			case 'Cprm':
				$controller = new CprmController();
			break;
		}
		
		$controller->{ $action }();
	}
	
	$controllers = array('Cprm' => ['home', 'error']);
	
	if (array_key_exists($controller, $controllers)) {
		if(in_array($action, $controllers[$controller])) {
			call($controller, $action);
		}
		else {
			call('Cprm','error');
		}
	}
	else {
		call('Cprm','error');
	}
?>