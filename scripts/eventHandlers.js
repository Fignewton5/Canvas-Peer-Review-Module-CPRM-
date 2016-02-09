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
	
	
	//function to load HTML into test box
	var req = new XMLHttpRequest();				//instantiate XMLHttpRequest object (AJAX required)
	req.onreadystatechange = function(){
		
		//if the state of the object is ready and we have an OK from the GET
		if(req.readyState == 4 && req.status == 200){
		
			//replace the element with id="test" (div-panel in our case)
			//with the response text provided in other file
			document.getElementById("test").innerHTML = req.responseText;
		}
	};
	
	//carry out AJAX calls
	req.open("GET", "views/cprm/grades.php", true);
	req.send();
	$(this).addClass('active');
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
 * Courses Event Handlers
 */

$('.course').on('click', function() {
	var canvasId = $(this).attr('id');
	var osuId = $(this).attr('data-id');
	var course = $(this).attr('data-name');
	$('#hiddenCourse').val(course);
	$('#hiddenId').val(canvasId);
	$('#hiddenOsu').val(osuId);
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
