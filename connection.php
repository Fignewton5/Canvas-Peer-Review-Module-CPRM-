<?php
	// class Db extends MySQLi {
		// //admint7unJmx
		// //127.6.241.130:3306
		// //cprmphp
		// //gbx6usvfglgc
		// private static $instance = null;
// 		
		// private function __construct($host, $user, $password, $database, $port){ 
        	// parent::__construct($host, $user, $password, $database, $port);
     	// }
// 		
		// public static function getInstance() {
			// if (self::$instance == null) {
				// self::$instance = new self("127.6.241.130", "admint7unJmx", "gbx6usvfglgc", "cprmphp", "3306");
// 				
			// }
// 			
			// return self::$instance;
		// }
	// }
	class Db {
		private static $instance = NULL;
		
		private function __construct() {}
		
		private function __clone() {}
		
		public static function getInstance() {
			if (!isset(self::$instance)) {
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				self::$instance = new PDO('mysql:host=127.6.241.130;port=3306;dbname=cprmphp', 'admint7unJmx', 'gbx6usvfglgc', $pdo_options);
			}
			
			return self::$instance;
		}
	}
?>
