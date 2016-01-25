//simple function to pull sample data
function testCanvas(){
	$.ajax({
		type: "GET",
		url: "https://canvas.instructure.com/api/v1/courses.json",
		dataType: 'json',
		headers: {
			'Access-Control-Allow-Origin': '*'
		},
		data: {
			access_token: '7~q4gP4CjVRpnLCgJQTXfNRJRmSIXNyv7nZZif5j44aGW0VByeY5cdnV9gObYYY60i'
		},
		success: function(data, status, xhr){
			alert(JSON.stringify(data));
		}
	});
}
