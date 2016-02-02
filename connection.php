<?php
	class Db extends mysqli {
		private static $instance = NULL;
		
		private function __construct($host, $user, $pw, $db, $port) {
			echo "WORKING";
			parent::__construct($host, $user, $pw, $db, $port);
		}
		
		public static function getInstance() {
			if (self::$instance == NULL) {
				define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
				define('DB_PORT', getenv('OPENSHIFT_MYSQL_DB_PORT'));
				define('DB_USER', getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
				define('DB_PASS', getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
				define('DB_NAME', getenv('OPENSHIFT_APP_NAME'));
				self::$instance = new self(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
			}
			
			return self::$instance;
		}
	}
