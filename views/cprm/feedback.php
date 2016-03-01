<?php
	//redirect to login if not logged in
	session_start();
	if (!isset($_SESSION['token'])) {
		header("Location: ?controller=account&action=login");
	}
?>

<div class="container-fluid">
	<div class="panel panel-default" style="margin-top:5px;">
		<div class="panel-body" id="test">
			<div class="row" style="margin-top:15px;">
				<div class="col-md-3" style="float:left;">
					<div class="feedback-side-menu">
						<div style="padding-bottom:2px;">
							<button type="button" class="btn btn-default feedback-button-fixes" id="single">
								Single Reviews (<?php 
									require_once('classes/dbInterface.php');
									$dbInt = new DbInterface();
									//get number of user reviews
									$uReviews = $dbInt->getUserReviews($_SESSION['id']);
									$uReviewsArray = array();
									
									$row = $uReviews->fetch();
									// foreach ($uReviews->fetch() as $row) {
// 										
										// if ($row['reviewComplete'] == 0) {
											// //add reviews to this page if they haven't been completed and save them
											// $uReviewsArray[0][] = $row;
										// }
// 										
									// }
									//echo the number of rows in userReviews
									echo $uReviews->rowCount();
								?>)
							</button>
							<input type='hidden' value='<?php print_r($row); ?>' id='uReviews' />
						</div>
						<div style="padding-top:2px;">
							<button type="button" class="btn btn-default feedback-button-fixes" id="group">
								Group Reviews (<?php
								$gReviews = $dbInt->getGroupReviews($_SESSION['id']);
								echo $gReviews->rowCount();
								?>)
							</button>
							<input type='hidden' value='<?php echo json_encode($gReviews); ?>' id='gReviews' />
						</div>
					</div>
				</div>
				<?php
					//this is responsible for setting pre-review information
					
					//pull and ready the first user review as default
					$review = $row;
					
					//get number of fields used for review for loop
					$fieldsLength = $review['fieldsUsed'];
					
				?>
				<h2><?php print_r($row); ?></h2>
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
								<tbody id='tbody'>
									<?php
										//iterate through the fields and points
										//as each field is laid out with a number appended, iterating through works
										for ($i = 0; $i < $fieldsLength; $i++) {
											echo "<tr>";
											echo "<td class='feedback-tb-top-padding'>" . $review['field' . $i] . "</td>";
											echo "<td class='feedback-tb-top-padding'>" . $review['pMax' . $i] . "</td>";
											echo "<td><input type='text' style='width:20%' class='form-control' value='" . $review['pEarn' . $i] . "' /></td>";
											echo "</tr>";
										}
										
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
				
					<button type='submit' class='btn btn-default'>Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
