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
		$file = fopen("token.txt",'r');
		$token = fgets($file);
		$this->canvasAccessToken = $token;
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
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
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
