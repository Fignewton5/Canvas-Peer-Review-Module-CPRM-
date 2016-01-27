//check other tags for active class
function removeActiveDropdown() {
	if ($('#peerReviews').hasClass('active')) {
		$('#peerReviews').removeClass('active');
	}
	
	if ($('#grades').hasClass('active')) {
		$('#grades').removeClass('active');
	}
	
	if ($('#feedbackSubmission').hasClass('active')) {
		$('#feedbackSubmission').removeClass('active');
	}
	
	if ($('#studentInformation').hasClass('active')) {
		$('#studentInformation').removeClass('active');
	}
}
