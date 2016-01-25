<?php
	header("Access-Control-Allow-Origin: https://www.oregonstate.instructure.com");
	header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
	header("Access-Control-Allow-Headers: Content-Type");
	
	//using requiremind's PHP MVC format - http://requiremind.com/a-most-simple-php-mvc-beginners-tutorial/
	if (isset($_GET['controller']) && isset($_GET['action'])) {
		$controller = $_GET['controller'];
		$action 	= $_GET['action'];
	}
	else {
		$controller = 'cprm';
		$action		= 'home';
	}
	
	require_once('views/layout.php');
?>