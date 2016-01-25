<?php

class CanvasAuth
{
	private $timeout = 10;
	private $domain = "https://oregonstate.instructure.com";
	private $canvasAuthorizeUrl = ""; //do not change
	private $canvasAccessToken = "1002~dBAbJ2p3LCUVQTdnVjYkiB2LLDUNg5PNJTEOUs8CgXXx21j4q8BnQWuGKcIbyLdd"; //oregonstate.instructure access token
	private $clientId;
	private $clientSecret;
	private $redirectUrl;
	
	// public function __construct($clientId = null, $clientSecret = null) {
		// if()
	// }
	
	
	/*
	 * runs the command through canvas
	 * 
	 * @param $url is the endpoint for canvas: courses, etc.
	 */
	private function askCanvas($url) {
		$tokenHeader = array("Authorization: Bearer ".$this->canvasAccessToken);
		
		$curl = curl_init($url);
		
		curl_setopt($curl, CURLOPT_URL, $domain . '/api/v1/' . $url);
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $tokenHeader); //sets token in header
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //stops response
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeout); //set timeouts
		curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
		
		$result = curl_exec($curl);
		var_dump($result);
	}
}
