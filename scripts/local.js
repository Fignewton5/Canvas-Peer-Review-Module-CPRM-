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

/*
 * These functions are for the peerReviews.php page
 * 
 */

//adds a criteria row to the rubric creation table
function addRowRubric(){

	//first count how many rows are inside the rubric table
	//because our database only allows for 10 criteria per rubric
	var rowCount = $("#rubric-table-body > tr").length;
	
	//if less than 10 rows, add a new row
	if(rowCount < 10){
	
		//create <tr></tr> element
		var row = document.createElement("tr");
		//fill element with table row data
		var td1 = '<td><input type="text" class="form-control" value="" name="row' + rowCount + 'crit" required></td>';
		var td2 = '<td><input type="text" style="width:20%" class="form-control" value=""  name="row' + rowCount + 'pts" required></td>';
		var rowData = td1 + td2;
		row.innerHTML = rowData;
		
		//plug the row into the <tbody> 
		$("#rubric-table-body").append(row);
	}
	else alert("Maximum amount of rows reached! [10]");
}

//removes a criteria row from the rubric creation table
function removeRowRubric(){

	//first count how many rows are inside the rubric table
	//so that we don't try to remove a row when we have 1 row
	var rowCount = $("#rubric-table-body > tr").length;
	
	//if more than 1 row, remove a row
	if(rowCount > 1){
		//remove the last row in the rubric table
		$("#rubric-table-body > tr:last").remove();
	}
	else alert("Can't remove first row!");
}

//displays the HTML for creating a rubric
function createRubric(){
	$("#group-assign-table").hide();
	$("#rubric-table").show();
}

//displays the HTML for assigning a group
function assignGroup(){
	$("#rubric-table").hide();
	$("#group-assign-table").show();
}
