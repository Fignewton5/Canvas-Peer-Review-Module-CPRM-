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
			$splitName = $this->splitCourseName($data->name);
			$this->buttonMaker($data->id, $splitName, true);
		}
	}
	
	
	/*
	 * takes a course title and splits the name and the OSU ID
	 * @param $title string in the format of 'Computer Science (CS_457_X001_W2016)'
	 * 
	 * @return array of two items, array[0] = name, array[1] = OSU ID
	 * 
	 */ 
	private function splitCourseName($title) {
		//pattern matches a string like: (CS_457_X001_W2016)
		$pattern = "/\(?[a-zA-Z]{2,}\_[0-9]{3}\_[a-zA-Z0-9]{3,}\_[a-zA-Z0-9]{5}\)?/";
		
		$nameArray = array();
		$result = explode('(', $title);
		$nameArray[] = $result[0];
		
		if (preg_match($pattern, $title, $match)) {
			$nameArray[] = $match[0];
		}
		
		return $nameArray;
	}
	
	/*
	 * directly echos button content to page
	 * @param $id string an id for the button
	 * @param $title array $title[0] = name, $title[1] = OSU ID
	 * @param $rowWrap bool whether or not the buttons should be wrapped in a row
	 * 					defaults to no wrapping
	 * 
	 */
	private function buttonMaker($id, $title, $rowWrap = false) {
		if ($rowWrap) {
			echo "<div style='margin-top:5px;'>";
			echo "<button id='" . $id . "' type='button' data-id='" . $title[1] . "' data-name='" . $title[0] . "' class='btn btn-default courseSwitch'>" . $title[0] . "</button>";
			echo "</div>";
		}
		else {
			echo "<button id='" . $id . "' type='button' data-id='" . $title[1] . "' data-name='" . $title[0] . "' class='btn btn-default courseSwitch'>" . $title[0] . "</button>";
		}
	}
}
