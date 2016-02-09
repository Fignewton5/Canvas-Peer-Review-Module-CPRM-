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
			$sql = "INSERT INTO users (osuId,token,name) VALUES (" . $user->user_id . ",'" . $token . "','" . $user->name . "')";
			$result = $this->db->query($sql);
		}
		
		//checks user token to see if it exists returns bool
		public function checkUserToken($token) {
			$sql = "SELECT * FROM users WHERE token='" . $token . "'";
			$result = $this->db->query($sql);
			
			//have to do a fetch to get a row
			$row = $result->fetch();
			//if fetch is empty
			if (!$row) {
				return FALSE;
			}
			return TRUE;
		}
	}
