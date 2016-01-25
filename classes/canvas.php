<?php

class Canvas
{
	private $canvasAccessToken = "1002~dBAbJ2p3LCUVQTdnVjYkiB2LLDUNg5PNJTEOUs8CgXXx21j4q8BnQWuGKcIbyLdd"; //oregonstate.instructure access token
	
	private $response;
	public $responseCode;
	
	private $endPointUrl;
	
	public function __construct() {
		
	}
	
	public function getCoursesForUser() {
		$this->endPointUrl = 'courses';
		return $this->getCanvas();
	}
	
	private function getCanvas() {
		$tokenHeader = array("Authorization: Bearer ".$this->canvasAccessToken);
		
		$curl = curl_init();
		
		curl_setopt($curl, CURLOPT_URL, $domain . '/api/v1/' . $this->endPointUrl);
		
		curl_setopt($curl, CURLOPT_HTTPHEADER, $tokenHeader); //sets token in header
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //stops response
		//curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeout); //set timeouts
		//curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_HEADER, 1);
		
		$this->response = curl_exec($curl);
		$this->responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
		//var_dump($this->response);
		
		curl_close($curl);
		
		return $this->response;
	}
	
	public function hasError() {
		return !in_array($this->responseCode, array(200,201)) || is_null($this->response);
	}
	
	public function getData() {
		echo $this->response;	
		
		if (!$this->hasError()) {
			$result = json_decode($this->response);
			return $result;
		}
		return null;
	}
}
