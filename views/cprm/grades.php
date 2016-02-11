<!-- This will be the grades table that shows the students' grades -->
<div class="container-fluid">
	<div class="panel panel-default" style="margin-top:5px;">
		
		<!-- What a professor would see -->
		<div class="panel-body" id="profView">
			<!-- Search Bar -->
			<div class="row" style="width:800px">
					<label for="gradesSearch"> Search </label>
					<input type="text" class="form-control" id="gradesSearch" placeholder="Student">
			</div>
			
			<br></br>
			
			<!-- Import / Export Buttons -->
			<div class="row" style="width:800px">
				<button type="button" class="btn-default" id="importGrades">Import</button>
				<button type="button" class="btn-default" id="exportGrades">Export</button>
			</div>

			<br></br>
			
			<!-- Table in which grades data will be displayed -->
			<h2>GRADES [TEST]</h2>
				<table class="table-bordered" style="width:800px">
					<thead>
						<tr>
							<th>Student Name</th>
							<th>Student ID</th>
							<th>Peer Eval 1</th>
							<th>Peer Eval 2</th>
							<th>Peer Eval 3</th>
							<th>Peer Eval Submitted</th>
						</tr>
					</thead>
					
					<tbody id="grades-table-body">
					
					</tbody>
				</table>
			</div>
			
			<!-- What a student would see -->
			<div class="panel-body" id="profView">
			STUDENT SEES THIS
			</div>
			
	</div>
</div>

<br></br>

<!-- Button to test loading table rows -->
<div class="container">
	<button type="button" class="btn-default" id="load-grades" onclick="loadGrades()">Load Grades [TEST]</button>
</div>