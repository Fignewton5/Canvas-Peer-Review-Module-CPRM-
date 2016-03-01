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
		
		/*
		 * This is the base function for getting reviews from the DB
		 * 
		 * @params $id int(9) osuId, $isGroup bool get user/group reviews,
		 * 			$skip bool skip the is group check and get all reviews
		 * 
		 * @return false if nothing, otherwise all rows that match
		 * 
		 */
		private function getReviews($id, $isGroup, $skip) {
			if ($skip) {
				$sql = "SELECT * FROM review WHERE reviewBy='" . $id . "' AND reviewComplete=0";
			}
			else {
				$sql = "SELECT * FROM review WHERE reviewBy='" . $id . "' AND isGroup=" . $isGroup . " AND reviewComplete=0";
			}
			
			$result = $this->db->query($sql);
			
			$row = $result->rowCount();
			
			if ($row == 0) {
				return FALSE;
			}
			else {
				return $result;
			}
		}
		
		/*
		 * Get every user review matching $id from the DB
		 * see _getReviews
		 * 
		 * 
		 */
		public function getUserReviews($id) {
			return $this->getReviews($id, 0, 0);
		}
		
		/*
		 * Get every group review matching $id from the DB
		 * see _getReviews
		 * 
		 */
		public function getGroupReviews($id) {
			return $this->getReviews($id, 1, 0);
		}
		
		/*
		 * Get every review matching $id from the DB
		 * see _getReviews
		 * 
		 */ 
		public function getAllReviews($id) {
			return $this->getReviews($id, 0, 0);
		}
		
		/*
		 * 
		 * 
		 * 
		 */
		private function submitReview($result, $isGroup) {
			if ($isGroup) {
				//do special group logic
			}
			
			else {
				$sql = "UPDATE review SET ";
				for ($i = 0; $i < $result->fieldsUsed; $i++) {
					if ($i == $result->fieldsUsed - 1) {
						$sql = $sql . "reviewComplete=" . $i;
					}
					else {
						$sql = $sql . "pEarn" . $i . "=" . $result->points[$i] . " , ";
					}
				}
				
				$sql = $sql . " WHERE reviewName='" . $result->primaryKey . "'";
				
				if ($this->db->query($sql)) {
					return 0;
				}
			}
			
			
			
		}
		
		/*
		 * 
		 * 
		 * 
		 */
		public function submitUserReview($result) {
			return $this->submitReview($result, 0);
		}
		
		/*
		 * 
		 * 
		 * 
		 */
		public function submitGroupReview($result) {
			return $this->submitReview($result, 1);
		}
		

	}
