<?php
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
