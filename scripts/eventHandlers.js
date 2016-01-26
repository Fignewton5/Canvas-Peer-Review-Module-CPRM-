/*
 * Navbar event handlers
 */
$('#courses').on('hover', function() {
	//dropdown stuff here
});

$('#peerReviews').on('click', function() {
	//handle peer reviews click
});

$('#grades').on('click', function() {
	//handle grades tab click
	
	alert("Grades Clicked!")
	
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
	
});

$('#feedbackSubmission').on('click', function() {
	//handle feedback submission click
});

$('#studentInformation').on('click', function() {
	//handle student information click
});


/*
 * course button event handlers
 */
$('.courseSwitch').on('mouseover', function() {
	var $width = $(this).width();
	
	var $prevHtml = $(this).html();
	
	var $id = $(this).attr('data-id');
	
	//maintain same size of button
	//if name is longer than ID
	//otherwise increase size to fit Id
	if ($prevHtml.length > $id.length) {
		$(this).width($width);
	}
	
	$(this).html($id);
});

$('.courseSwitch').on('mouseout', function() {
	var $name = $(this).attr('data-name');
	$(this).html($name);
});
