//simple function to pull sample data
function testCanvas(){
	$.ajax({
		type: "GET",
		url: "https://oregonstate.instructure.com/api/v1/courses.json",
		dataType: 'json',
		data: {
			access_token: '1002~mv0PPyv9qUsNq9DGc9ohRXCKuV3I5J7D3ar7BKXitIVJsI6lljRluw0DPW87NY2M'
		},
		success: function(data, status, xhr){
			alert(JSON.stringify(data));
		}
	});
}
