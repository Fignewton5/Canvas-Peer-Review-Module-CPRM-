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
		 * 
		 * 
		 * 
		 */
		public function getUserFromId($id) {
			$sql = "SELECT * FROM users WHERE osuId=" . $id;
			$result = $this->db->query($sql);
			
			$row = $result->fetch();
			
			if (!$row) {
				return FALSE;
			}
			else {
				return $row;
			}
		}
		
		/*
		 * This function uses the current user's token
		 * to retrieve their OSU ID
		 * 
		 * @params $token access token from $_SESSION array
		 * that will be used in a query to retrieve the user's ID
		 * 
		 * @return FALSE if query failed, otherwise all rows that match
		 *
		 */
		public function getIDFromToken($token) {
		
			//construct query to grab the user's OSU ID by using their token
			$query = "SELECT * FROM users WHERE token='" . $token . "'";
			//execute query
			$result = $this->db->query($query);
			
			//get next row of returned results (should only be one row)
			$row = $result->fetch();
			
			//if query failed
			if (!$row) {
				echo 'Error getting OSU ID!';
				return FALSE;
			}
			//return OSU ID
			else {
				return $row['osuId'];
			}
		}
		
		/*
		 * This function is used by the Grades tab and uses the current user's
		 * OSU ID and course ID to grab all records of peer reviews done for 
		 * the current student by his / her peers.
		 *
		 * @params $osuId the current user's OSU ID to be used in the SQL query
		 *				   $courseId the current user's active course id to be used in the SQL query
		 *
		 * @return FALSE if query fails
		 * 			 otherwise, return all rows matching the query (peer reviews done for the student)
		 */
		public function getStudentGrades($osuId, $courseId){
			
			//construct query to grab peer reviews done for the current student
			//in the currently active course
			$query = "SELECT * FROM review WHERE reviewFor='" . $osuId . "' AND forClass='" . $courseId . "'";
			//echo $query;
			//execute query
			$result = $this->db->query($query);
			
			//check the result to see if it worked
			if($result){
				return $result;
			}
			//query failed
			else{
				echo 'Error getting student grades!';
				return FALSE;
			}
		}
		
		
		/*
		 * This is the base function for getting reviews from the DB
		 * 
		 * @params $id int(9) osuId, $courseId canvas ID integer
		 * 			$isGroup bool get user/group reviews,
		 * 
		 * @return false if nothing, otherwise all rows that match
		 * 
		 */
		private function getReviews($id, $courseId, $isGroup) {
			//isGroup will return the right results based off what is passed in
			$sql = "SELECT * FROM review WHERE reviewBy='" . $id . "' AND isGroup=" . $isGroup . " AND reviewComplete=0 AND forClass=" . $courseId;
			
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
		public function getUserReviews($id, $courseId) {
			return $this->getReviews($id, $courseId, 0);
		}
		
		/*
		 * Get every group review matching $id from the DB
		 * see _getReviews
		 * 
		 */
		public function getGroupReviews($id, $courseId) {
			return $this->getReviews($id, $courseId, 1);
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
