<?php

class Canvas
{
	private $canvasAccessToken = ""; //oregonstate.instructure access token
	private $domain = "https://oregonstate.instructure.com"; //entry point for API
	
	private $response;
	public $responseCode;
	
	private $endPointUrl; //assigned by each request
	
	/*
	 * set the token from token.txt in git ignore
	 * 
	 */ 
	public function __construct() {
	
		//grab user token from session variable
		$token = $_SESSION['token'];
		$this->canvasAccessToken = $token;
		
		//run function to grab user ID and store as a session variable
		$this->getUserID();
	}
	
	/*
	 * gets user ID from the current user
	 * 
	 */
	public function getUserID() {
		$this->endPointUrl = 'users/self';
		$info = $this->getCanvas();
		
		//if the user_id session variable is not set
		if (!isset($_SESSION['user_id']))
		{
			//set the session variable
			$_SESSION['user_id'] = $info->id;
		}
	}
	
	/*
	 * gets information about the current user
	 * 
	 */
	public function getUserInfo() {
		$this->endPointUrl = 'users/self';
		return $this->getCanvas();
	}
	
	/*
	 * gets information about courses the
	 * 			user is enrolled in
	 * 
	 */
	public function getCoursesForUser() {
		$this->endPointUrl = 'courses';
		return $this->getCanvas();
	}
	
	/*
	 * This returns the enrollment of the user
	 * will show if they are a student or teacher
	 * 
	 */ 
	public function getUserEnrollment() {
		
		//grab course_id from session variable for CURL call
		$course_id = $_SESSION['course']->id;
		$this->endPointUrl = 'courses/' . $course_id . '/enrollments';
		
		//execute the CURL call
		$result = $this->getCanvas();
		
		//grab user ID using other function
		$data = $this->getUserInfo();
		
		//variable to return
		$enrollment = NULL;
		
		//iterate through the enrollments for the course
		foreach($result as $item){
		
			//if the user_id of the enrollment and the session variable match
			//then that is the enrollment for the current user in the current course
			if($item->user_id == $_SESSION['user_id']){
				$enrollment = $item->type;
			}
		}
		
		//if we got a valid enrollment, return it, otherwise return error
		if(isset($enrollment)){
			return $enrollment;
		}
		else return "Error Getting Enrollment!";
	}
	
	/*
	 * submits cURL request for the endpoint url
	 * 			selected by a previous function
	 * 
	 */
	private function getCanvas() {
		$tokenHeader = array("Authorization: Bearer ".$this->canvasAccessToken);
		$url = $this->domain . '/api/v1/' . $this->endPointUrl;
		
		$curl = curl_init();
		
		curl_setopt($curl, CURLOPT_URL, $url);
		
		curl_setopt($curl, CURLOPT_HTTPHEADER, $tokenHeader); //sets token in header
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //stops response
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_HEADER, 1);
		
		//REMOVE IN PRODUCTION THIS BLOCKS SSL VERIFICATION FOR LOCAL
		//curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		//REMOVE REMOVE REMOVE!!!!!!!!!!!!!!!!
		
		$curlResult = curl_exec($curl);
		$this->responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		//var_dump($this->response);	
		
		//separate header from body
		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$header = substr($curlResult, 0, $header_size);
		$body = substr($curlResult, $header_size);
		$this->response = json_decode($body);
		
		//uncomment to debug curl problems
		//echo curl_errno($curl);
		
		curl_close($curl);
		
		return $this->response;
	}
	
	/*
	 * checks the responseCode to see if an error
	 * 			was set or not
	 * 
	 */
	public function hasError() {
		return !in_array($this->responseCode, array(200,201)) || is_null($this->response);
	}
	
	/*
	 * returns the data from the cURL response
	 * 
	 */
	public function getData() {
		if (!$this->hasError()) {
			return $this->response;
		}
		return null;
	}
}
