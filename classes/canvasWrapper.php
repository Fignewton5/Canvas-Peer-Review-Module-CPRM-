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
		//print_r($this->canvas->getData());
		foreach ($this->canvas->getData() as $data) {
			$this->buttonMaker($data->id, $data->name, 1);
		}
	}
	
	
	/*
	 * directly echos button content to page
	 * @param $id string an id for the button
	 * @param $title string a title between the tags
	 * @param $rowWrap bool whether or not the buttons should be wrapped in a row
	 * 					defaults to no wrapping
	 * 
	 */
	private function buttonMaker($id, $title, $rowWrap = 0) {
		if ($rowWrap) {
			echo "<div class='row'>";
			echo "<button id='" . $id . "' type='button' class='btn btn-default'>" . $title . "</button>";
			echo "</div>";
		}
		else {
			echo "<button id='" . $id . "' type='button' class='btn btn-default'>" . $title . "</button>";
		}
	}
}
