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
});

$('#feedbackSubmission').on('click', function() {
	//handle feedback submission click
});

$('#studentInformation').on('click', function() {
	//handle student information click
});

$('.courseSwitch').on('mouseover', function() {
	var $width = $(this).width();
	
	var $prevHtml = $(this).html();
	alert($prevHtml.length);
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
