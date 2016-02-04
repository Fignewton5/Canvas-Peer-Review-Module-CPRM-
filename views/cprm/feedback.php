<div class="container-fluid">
	<div class="panel panel-default" style="margin-top:5px;">
		<div class="panel-body" id="test">
			<div class="row" style="margin-top:15px;">
				<div class="col-md-3" style="float:left;">
					<div class="feedback-side-menu">
						<div style="padding-bottom:2px;">
							<button type="button" class="btn btn-default feedback-button-fixes" id="single">
								Single Reviews
							</button>
						</div>
						<div style="padding-top:2px;">
							<button type="button" class="btn btn-default feedback-button-fixes" id="group">
								Group Reviews
							</button>
						</div>
					</div>
				</div>
				<?php
				
				
				$db = Db::getInstance();
				$query = 'SELECT * FROM Test1 WHERE reviewName="cs462"';
				$counter = 1;
				foreach ($db->query($query) as $row) {
					
					//echo $row['reviewName'] . " " . $row['pointMax'] . $row['field1'] . $row['pointFor1'];
				
				?>
				<form action="" method="post">
					<div class="col-md-7" style="float:left;">
						<div style="width:100%;">
							<table class="table table-striped table-condensed">
								<thead>
									<tr>
										<th>Evaluation Criteria</th>
										<th>Points Possible</th>
										<th>Points Earned</th>
									</tr>
								</thead>
								<tbody>
									<?php
										echo "<tr>";
										echo "<td class='feedback-tb-top-padding'>" . $row['field' . $counter] . "</td>";
										echo "<td class='feedback-tb-top-padding'>" . $row['pMax' . $counter] . "</td>";
										echo "<td><input type='text' style='width:20%' class='form-control' value='" . $row['pEarn1'] . "' /></td>";
										echo "</tr>";
									?>
									<!-- <tr>
										
										<td class="feedback-tb-top-padding"><?php echo $row['field1']; ?></td>
										<td class="feedback-tb-top-padding"><?php echo $row['pointMax'];?> Points</td>
										<td><input type='text' style="width:20%;" class='form-control' value='<?php echo $row['pointFor1'];?>' /></td>	
									</tr> -->
								</tbody>
							</table>
						</div>
					</div>
					<?php $counter++; } ?>
					<div class="col-md-2">
						<button type='submit' class='btn btn-default'>Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
