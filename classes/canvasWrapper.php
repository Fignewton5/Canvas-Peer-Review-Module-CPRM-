<?php

class CanvasWrapper
{
	private $canvas;
	
	public function __construct() {
		require_once('classes/canvas.php');
		$this->canvas = new Canvas();
	}
	
	/*
	 * takes json result and formats it for printing
	 * 
	 */ 
	public function formatCourseData() {
			
		$this->canvas->getCoursesForUser();

		foreach ($this->canvas->getData() as $data) {
			$this->splitCourseName($data->name);
			$this->buttonMaker($data->id, $data->name, true);
		}
	}
	
	private function splitCourseName($title) {
		$pattern = "/\(?[a-zA-Z]{2,}\_[0-9]{3}\_[a-zA-Z0-9]{3,}\_[a-zA-Z0-9]{5}\)?/";
		if (preg_match($pattern, $title, $match)) {
			echo "match found.<br><br>";
		}
		print_r($match);
	}
	
	/*
	 * directly echos button content to page
	 * @param $id string an id for the button
	 * @param $title string a title between the tags
	 * @param $rowWrap bool whether or not the buttons should be wrapped in a row
	 * 					defaults to no wrapping
	 * 
	 */
	private function buttonMaker($id, $title, $rowWrap = false) {
		if ($rowWrap) {
			echo "<div style='margin-top:5px;'>";
			echo "<button id='" . $id . "' type='button' class='btn btn-default courseSwitch'>" . $title . "</button>";
			echo "</div>";
		}
		else {
			echo "<button id='" . $id . "' type='button' class='btn btn-default courseSwitch'>" . $title . "</button>";
		}
	}
}
