<?php
	class Db extends MySQLi {
		//admint7unJmx
		//127.6.241.130:3306
		//cprmphp
		//gbx6usvfglgc
		private static $instance = null;
		
		private function __construct() {
			
		}
		
		public static function getInstance() {
			if (self::$instance == null) {
				self::$instance = new self();
				
			}
			
			return self::$instance;
		}
	}
