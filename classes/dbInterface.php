<?php

	//this class will interface with canvas and
	class DbInterface {
		private $db;
		
		public function __construct() {
			$this->db = Db::getInstance();
		}
		
		//adds user into DB
		public function addUserToDb($token) {
			require_once('classes/canvasWrapper.php');
			$canvas = new CanvasWrapper();
			$user = $canvas->formatUserData();
			$sql = "INSERT INTO users (osuId,token,name) VALUES ('" . $user->user_id . "','" . $token . "','" . $user->name . "')";
			$result = $this->db->query($sql);
		}
		
		//checks user token to see if it exists returns bool
		public function checkUserToken($token) {
			echo "<br></br>";
			echo "BEFORE SQL!!!";
			$sql = "SELECT * FROM users WHERE token='" . $token . "'";
			echo "<br></br>"; 
			echo $sql;
			$result = $this->db->query($sql);
			//echo $result;
			var_dump($result);
			if (empty($result)) {
				echo "returneed false";
				return FALSE;
			}
			return TRUE;
		}
	}
