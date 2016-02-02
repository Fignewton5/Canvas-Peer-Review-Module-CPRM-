<?php
	//using requiremind's PHP MVC format - http://requiremind.com/a-most-simple-php-mvc-beginners-tutorial/
	echo getenv('OPENSHIFT_MYSQL_DB_HOST');
	require_once('connection.php');
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