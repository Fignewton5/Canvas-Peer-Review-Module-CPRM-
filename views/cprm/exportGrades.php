<div>Export Grades</div>

<?php
	
	//clean output buffers to prevent HTML from being inserted into CSV file
	ob_end_clean();
	
	//get session variables
	session_start();

	//HTTP headers ensure that the file is downloaded rather than displayed 
	//& properly formatted
	header("Content-Type: text/csv; charset=utf-8");
	header("Content-Disposition: attachment; filename=grades_" . $_SESSION['course']->courseName . ".csv");
	
	//create a file pointer using standard php output stream
	$fp = fopen("php://output", "w");
	
	//output the column headings
	fputcsv($fp, array("Assignment", "Review By", "Review For", "Criteria 1", "Criteria 2", "Criteria 3", "Criteria 4", "Criteria 5", "Criteria 6", "Criteria 7", "Criteria 8", "Criteria 9", "Criteria 10"));

	//fetch grades
	require_once("classes/dbInterface.php");
	$db = Db::getInstance();
	$query = "SELECT reviewName, reviewBy, reviewFor, pEarn0, pEarn1, pEarn2, pEarn3, pEarn4, pEarn5, pEarn6, pEarn7, pEarn8, pEarn9 FROM review WHERE forClass='" . $_SESSION['course']->id . "'";
	//second argument makes sure that duplicate indices aren't fetched
	$result = $db->query($query, PDO::FETCH_ASSOC);
	
	//iterate over results and output to CSV format
	foreach($result as $row){
		 fputcsv($fp, $row);
	}
	
	//prevent html from slipping into CSV
	//from header (</html> & </body> tags)
	die();
	
?>