<?php

	//using requiremind's PHP MVC format - http://requiremind.com/a-most-simple-php-mvc-beginners-tutorial/
	if (isset($_GET['controller']) && isset($_GET['action'])) {
		$controller = $_GET['controller'];
		$action 	= $_GET['action'];
	}
	else {
		$controller = 'Cprm';
		$action		= 'home';
	}
	
	require_once('views/layout.php');
?>