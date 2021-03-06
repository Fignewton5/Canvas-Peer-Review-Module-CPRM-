<?php

class CanvasWrapper
{
	private $canvas;
	
	public function __construct() {
		require_once('classes/canvas.php');
		$this->canvas = new Canvas();
	}
	
	/*
	 * takes a user's token and returns bool on validation
	 * 
	 * @return bool, true if valid, false if not
	 * 
	 */ 
	public function testToken() {
		$this->canvas->getUserInfo();
		if ($this->canvas->hasError()) {
			return false;
		}
		return true;
	}
	
	/*
	 * takes json result and formats it for printing
	 * 
	 * @return $courseHolder an array:
	 * 			object{
	 * 				id: canvas id,
	 * 				courseName: osu course name (Shaders),
	 * 				osuId: osu course id (CS 457 X001 W2016)
	 * 			}
	 * 
	 */ 
	public function formatCourseData() {
			
		$result = $this->canvas->getCoursesForUser();
		
		//course object array
		$courseHolder = array();

		foreach ($result as $data) {
			$splitName = $this->splitCourseName($data->name);
			
			//split OSU Id for checking and printing
			$splitArr = explode(" ", $splitName[1]);
			
			
			
			//don't add course to object unless it's this term
			if ($this->checkCourseTerm($splitArr[4])) {
				// don't create object unless necessary
				$courseObject = new stdClass();
				
				$courseObject->id = $data->id;
				$courseObject->courseName = $splitName[0];
				$courseObject->osuId = $splitName[1];
				
				$courseHolder[] = $courseObject;
			}
			// THIS IS TO HANDLE THE TEST COURSE ADDITION FOR EXPO
			// 10020000001597490 - full course handle
			else if (strpos($data->id, "1597490") !== false) {
				$courseObject = new stdClass();
				$courseObject->id = $data->id;
				$courseObject->courseName = $splitName[0];
				$courseObject->osuId = $splitName[1];
				
				$courseHolder[] = $courseObject;
			}
		}
		return $courseHolder;
	}
	
	/*
	 * takes json result for canvas user and formats it
	 * 			returns a user object
	 * 
	 * @return $user object{
	 * 					name: user's name
	 * 					email: user's OSU email
	 * 					user_id: user's OSU Id
	 * 					canvas_id: user's Canvas Id	
	 * 		   		 }
	 * 
	 */ 
	public function formatUserData() {
		
		$this->canvas->getUserInfo();
		$data = $this->canvas->getUserInfo();
		$user = new stdClass();
		$user->name = $data->name;
		$user->email = $data->login_id;				//NO LONGER HAVE ACCESS TO , THANKS CANVAS <3
		$user->user_id = $data->sis_user_id; 	//NO LONGER HAVE ACCESS TO , THANKS CANVAS <3
		$user->canvas_id = $data->id;
		return $user;
	}
	
	/*
	 * This function will handle the request
	 * and formatting of the user enrollment request
	 * and a string.
	 * 
	 * @return $enrollment: string that looks like "_____Enrollment"
	 *								(Student, Teacher, Ta, Designer, Observer)
	 *						
	 */ 
	public function formatEnrollment() {
		
		//call function to check user enrollment for the current course
		$enrollment = $this->canvas->getUserEnrollment();
		
		//return enrollment string
		return $enrollment;
	}
	
	/*
	 * This function will determine and 
	 * set a variable that states whether
	 * the user is a student or a teacher
	 * 
	 */ 
	public function checkEnrollment() {
		
		//get enrollment type
		$enrollment = $this->formatEnrollment();
		
		//output enrollment based on contents of string
		switch($enrollment){
			case 'StudentEnrollment':
				return 'student';
				break;
				
			case 'TeacherEnrollment':
				return 'teacher';
				break;
				
			case 'TaEnrollment':
				return 'ta';
				break;
				
			case 'DesignerEnrollment':
				return 'designer';
				break;
				
			case 'ObserverEnrollment':
				return 'observer';
				break;
			
			default:
				echo '<div>CHECK ENROLLMENT: Error occurred!' . $enrollment . '</div>';
		}
		
	}
	
	/* 
	 * This function takes the result from the CURL request, which
	 * should return a list of all students in a course, then packs their
	 * student ID's into an array to be returned.
	 *
	 * @params	$courseId id of the course to perform student lookup on
	 *
	 * @return		$students array of student ID's to return
	 *
	 */
	public function getStudentsInCourse($courseId){

		//grab results back from canvas CURL query (array of student ID's)
		$students = $this->canvas->getUsersForCourse($courseId);
		
		//return array of student id's
		return $students;
	}
	
	/*
	 * This prints out a greeting to the user
	 * based off of a call to the formatUserData
	 * This is specifically supposed to be used in a 
	 * panel-heading on the home page
	 * 
	 */ 
	public function printUserName() {
		$user = $this->formatUserData();
		//echo "<div class='well well-sm'>";
		echo "Welcome $user->name.";
		//echo "</div>";
	}
	
	
	/*
	 * gets the current OSU Term i.e. W2016 and compares
	 * 			against term passed in
	 * @param $term and OSU Term: W2016
	 * 
	 * @return bool true on term equal, false otherwise 
	 * 
	 */ 
	private function checkCourseTerm($term) {
		//get current month
		$currentMonth = date("m");
		 
		//retrieve season in OSU Term format
		if ($currentMonth >= "04" && $currentMonth <= "06") {
			$season = "S";
		}
		elseif ($currentMonth >= "06" && $currentMonth <= "08") {
			$season = "U";
		}
		elseif ($currentMonth >= "09" && $currentMonth <= "11") {
			$season = "F";
		}
		else {
			$season = "W";
		}
		
		//get current year
		$currentYear = date("Y");
		$curTerm = $season . $currentYear;
		
		if ($term == $curTerm) {
			return true;
		}
		
		return false;
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
		
		//converts (CS_457_X001_W2016) to CS 457 X001 W2016
		if (preg_match($pattern, $title, $match)) {
			$splitParen = substr($match[0], 1, -1);
			$splitUnder = explode('_',$splitParen);
			$result = '';
			foreach ($splitUnder as $item) {
				$result = $result . ' ' . $item;
			}
			$nameArray[] = $result;
		}
		
		return $nameArray;
	}
	
	/*
	 * This function queries for courses and
	 * generates a list of buttons for the courses with
	 * the value set as the course name
	 */ 
	public function createCourseButtons() {
		$courseArray = $this->formatCourseData();
		foreach ($courseArray as $course) {
			echo "<button type='submit' name='course' class='btn btn-default' ";
			//FIX ME LATER!!!!!! NOT PERMANENT FIX
			//$course->id = substr($course->id, -7, 7);
			echo "value='" . $course->id . "'>";
			echo $course->courseName . "</button>";
		}
	}
	
	/*
	 * DEPRECATED
	 * 
	 * Canvas dropdown has been moved to home tab
	 * this is to solve error of selecting a class
	 * 
	 * look at createCourseButtons() function
	 * 
	 */
	public function createCourseDropdown() {
		$courseArray = $this->formatCourseData();
		foreach ($courseArray as $course) {
			echo "<li id='" . $course->id . "' ";
			echo "data-id='" . $course->osuId . "' ";
			echo "data-name='" . $course->courseName . "'>";
			//echo "class='course'>"; 
			echo "<a href='#'>";
			echo $course->courseName;
			echo "</a></li>";
		}
	}
}
