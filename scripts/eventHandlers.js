/*
 * Navbar event handlers
 */
$('#courses').on('hover', function() {
	//dropdown stuff here
});

$('#peerReviews').on('click', function() {
	//handle peer reviews click
	
	//run this first, removes active class on navbar
	removeActiveDropdown();
	
	$(this).addClass('active');
});

$('#grades').on('click', function() {
	//handle grades tab click
	
	//run this first, removes active class on navbar
	removeActiveDropdown();
	
	
	// //function to load HTML into test box
	// var req = new XMLHttpRequest();				//instantiate XMLHttpRequest object (AJAX required)
	// req.onreadystatechange = function(){
// 		
		// //if the state of the object is ready and we have an OK from the GET
		// if(req.readyState == 4 && req.status == 200){
// 		
			// //replace the element with id="test" (div-panel in our case)
			// //with the response text provided in other file
			// document.getElementById("test").innerHTML = req.responseText;
		// }
	// };
// 	
	// //carry out AJAX calls
	// req.open("GET", "views/cprm/grades.php", true);
	// req.send();
	// $(this).addClass('active');
});

//function to load grades into table (currently filler students)
function loadGradesProf(){
	
	//table content to add
	var toAdd = document.createDocumentFragment();

	//test student info
	var student;
	var studentID;
	var peer1, peer2, peer3;
	var peerSubmitted;
 
	//create new element (table row) to be appended to grades table
	for(i = 0; i < 20; i++){
	
		student = "Student" + i;
		studentID = "600" + Math.floor((Math.random() * 99999) + 100000);
		peer1 = Math.floor((Math.random() *10) + 1);
		peer2 = Math.floor((Math.random() *10) + 1);
		peer3 = Math.floor((Math.random() *10) + 1);
		peer4 = Math.floor((Math.random() *10) + 1);
		
		//new row to be added
		var newRow = document.createElement('tr');
		newRow.innerHTML = '<td>' + student + '</td><td>' + studentID + '</td><td>'+ peer1 + '</td><td>'+ peer2 + '</td><td>'+ peer3 + '</td><td>' + peer4 + '</td>';
										
		//append to new object
		toAdd.appendChild(newRow);
	}
	
	//add element to table body
	document.getElementById('grades-table-body-professor').appendChild(toAdd);
}

//function to load grades into table (currently filler assignments)
function loadGradesStudent(){
	
	//table content to add
	var toAdd = document.createDocumentFragment();

	//test student info
	var peerReview;
	var description = "This is a sample description...";
	var criteria1, criteria2, criteria3, criteria4;
	var total;
 
	//create new element (table row) to be appended to grades table
	for(i = 0; i < 10; i++){
	
		peerReview = i;
		criteria1 = Math.floor((Math.random() *5) + 1);
		criteria2 = Math.floor((Math.random() *5) + 1);
		criteria3 = Math.floor((Math.random() *5) + 1);
		criteria4 = Math.floor((Math.random() *5) + 1);
		total = criteria1 + criteria2 + criteria3 + criteria4;
		
		//new row to be added
		var newRow = document.createElement('tr');
		newRow.innerHTML = '<td>' + peerReview + '</td><td>' + description + '</td><td>'+ criteria1 + '</td><td>'+ criteria2 + '</td><td>'+ criteria3 + '</td><td>' + criteria4 + '</td><td>' + total + '</td>';
										
		//append to new object
		toAdd.appendChild(newRow);
	}
	
	//add element to table body
	document.getElementById('grades-table-body-student').appendChild(toAdd);
}

/*	
	Function that will add a new criteria row to the rubric	

function addRowRubric(){
	alert("Add Row button has been clicked!");
}*/

/*	function that will show what a professor will 
	see on the grades page while hiding what a 
	student would see
*/
function showProfessorGrades(){
	//show the professor view
	document.getElementById('profView').style.display="block";
	
	//hide the student view
	document.getElementById('studentView').style.display="none";
}

/*	function that will show what a student will 
	see on the grades page while hiding what a 
	professor would see
*/
function showStudentGrades(){
	//show the student view
	document.getElementById('studentView').style.display="block";
	
	//hide the professor view
	document.getElementById('profView').style.display="none";
}

/*
	function that will import grades into the Grades page's table
*/
$('#importGrades').on('click', function importGrades(){
	alert("Import button clicked!");
});

/*
	function that will export grades from the Grades page's table
*/
$('#exportGrades').on('click', function exportGrades(){
	alert("Export button clicked!");
});

$('#feedbackSubmission').on('click', function() {
	//run this first, removes active class on navbar
	removeActiveDropdown();
	$(this).addClass('active');
});

$('#studentInformation').on('click', function() {
	//handle student information click
	//run this first, removes active class on navbar
	removeActiveDropdown();
	
	$(this).addClass('active');
});

/*
 * These event handlers are for the feedback page
 * they handle populating the table from the database
 * 
 */
$('#single').on('click', function() {
	var $tbody = $('#tbody');
	var $uReviews = $('#uReviews');
	var jsonValue = $('#uReviews').attr('value');
	
	$tbody.appendTo(JSON.stringify(jsonValue));
});

$('#group').on('click', function() {
	
});

/*
 * course button event handlers
 * 
 * COMMENTED OUT UNTIL FURTHER NEED, DOESN'T WORK IN NAVBAR DROPDOWN
 * 
 */
// $('.courseSwitch').on('mouseover', function() {
	// var $width = $(this).width();
// 	
	// var $prevHtml = $(this).html();
// 	
	// var $id = $(this).attr('data-id');
// 	
	// //maintain same size of button
	// //if name is longer than ID
	// //otherwise increase size to fit Id
	// // if ($prevHtml.length > $id.length) {
		// // $(this).width($width);
	// // }
// 	
	// $(this).html($id);
// });
// 
// $('.courseSwitch').on('mouseout', function() {
	// var $name = $(this).attr('data-name');
	// $(this).html($name);
// });
