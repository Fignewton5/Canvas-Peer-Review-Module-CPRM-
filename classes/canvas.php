<?php

class Canvas
{
	private $canvasAccessToken = "1002~dBAbJ2p3LCUVQTdnVjYkiB2LLDUNg5PNJTEOUs8CgXXx21j4q8BnQWuGKcIbyLdd"; //oregonstate.instructure access token
	private $domain = "https://oregonstate.instructure.com"; //entry point for API
	
	private $response;
	public $responseCode;
	
	private $endPointUrl; //assigned by each request
	
	public function __construct() {
		
	}
	
	public function getUserInfo() {
		$this->endPointUrl = 'users/self';
		return $this->getCanvas();
	}
	
	public function getCoursesForUser() {
		$this->endPointUrl = 'courses';
		return $this->getCanvas();
	}
	
	private function getCanvas() {
		$tokenHeader = array("Authorization: Bearer ".$this->canvasAccessToken);
		$url = $this->domain . '/api/v1/' . $this->endPointUrl;
		
		$curl = curl_init();
		
		curl_setopt($curl, CURLOPT_URL, $url);
		
		curl_setopt($curl, CURLOPT_HTTPHEADER, $tokenHeader); //sets token in header
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //stops response
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_HEADER, 1);
		
		$curlResult = curl_exec($curl);
		$this->responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		//var_dump($this->response);	
		
		//separate header from body
		$header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$header = substr($curlResult, 0, $header_size);
		$body = substr($curlResult, $header_size);
		$this->response = json_decode($body);
		
		curl_close($curl);
		
		return $this->response;
	}
	
	public function hasError() {
		return !in_array($this->responseCode, array(200,201)) || is_null($this->response);
	}
	
	public function getData() {
		if (!$this->hasError()) {
			return $this->response;
		}
		return null;
	}
}
