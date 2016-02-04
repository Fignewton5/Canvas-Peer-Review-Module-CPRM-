<?php
	class CprmController {
		public function home() {
			require_once('views/cprm/home.php');
		}
		public function error() {
			require_once('views/cprm/error.php');
		}
		public function feedback(){
			require_once('views/cprm/feedback.php');
		}
	}
?>