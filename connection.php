<?php
	class Db extends MySQLi {
		//admint7unJmx
		//127.6.241.130:3306
		//cprmphp
		//gbx6usvfglgc
		private static $instance = null;
		
		private function __construct($host, $user, $password, $database, $port){ 
        	parent::__construct($host, $user, $password, $database, $port);
     	}
		
		public static function getInstance() {
			if (self::$instance == null) {
				self::$instance = new self("127.6.241.130", "admint7unJmx", "gbx6usvfglgc", "cprmphp", "3306");
				
			}
			
			return self::$instance;
		}
	}
