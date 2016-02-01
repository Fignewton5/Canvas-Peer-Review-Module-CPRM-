<?php

	class Db {
		private static $instance = NULL;
		
		private function __construct() {}
		
		private function __clone() {}
		
		public static function getInstance() {
			if (!isset(self::$instance)) {
				// $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				// define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
				// define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT')); 
				// define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
				// define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
				// define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));
// 				
				// $dsn = 'mysql:dbname='.DB_NAME.';host='.DB_HOST.';port='.DB_PORT;
				// self::$instance = new PDO($dsn, DB_USER, DB_PASS, $pdo_options);
				// echo "db connected";
				$mysqlCon = mysqli_connect(getenv('OPENSHIFT_MYSQL_DB_HOST'), getenv('OPENSHIFT_MYSQL_DB_USERNAME'), getenv('OPENSHIFT_MYSQL_DB_PASSWORD'), "", getenv('OPENSHIFT_MYSQL_DB_PORT')) or die("Error: " . mysqli_error($mysqlCon));
				mysqli_select_db($mysqlCon, getenv('OPENSHIFT_APP_NAME')) or die("Error: " . mysqli_error($mysqlCon));
			}
			
			//return self::$instance;
		}
	}
