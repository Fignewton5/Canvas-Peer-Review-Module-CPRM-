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
	var $id = $(this).attr('data-id');
	$(this).html($id);
	
	//maintain same size of button
	$(this).width($width);
});

$('.courseSwitch').on('mouseout', function() {
	var $name = $(this).attr('data-name');
	$(this).html($name);
});
