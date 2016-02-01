<?php
	//using requiremind's PHP MVC format - http://requiremind.com/a-most-simple-php-mvc-beginners-tutorial/
	//require_once('connection.php');
	$mysqlCon = mysqli_connect(getenv('OPENSHIFT_MYSQL_DB_HOST'), getenv('OPENSHIFT_MYSQL_DB_USERNAME'), getenv('OPENSHIFT_MYSQL_DB_PASSWORD'), "", getenv('OPENSHIFT_MYSQL_DB_PORT')) or die("Error: " . mysqli_error($mysqlCon));
	mysqli_select_db($mysqlCon, getenv('OPENSHIFT_APP_NAME')) or die("Error: " . mysqli_error($mysqlCon));
	mysqli_query($mysqlCon, "INSERT INTO Test (review,maxPoints,field1) VALUES ('cs462','5','performance')");
	$result = mysqli_query($mysqlCon, "SELECT * FROM Test");
	var_dump($result);
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