<?php
	//redirect to login if not logged in
	session_start();
	if (!isset($_SESSION['token'])) {
		header("Location: ?controller=account&action=login");
	}
	
	//initialize DbInterface for use in page
	require_once('classes/dbInterface.php');
	$dbInt = new DbInterface();
	
	//handle post form update
	if (isset($_POST['reviewSubmit'])) {
		
		//holds results of all the points entered
		$pointArr = array();
		
		//holds results from form submit
		$result = new stdClass();
		
		$result->fieldsUsed = $_POST['fieldsUsed'];
		$result->primaryKey = $_POST['reviewPrimary'];
		
		//populate point results, each field in table
		for ($i = 0; $i < $_POST['fieldsUsed']; $i++) {
			
			//BUG BUG BUG
			//THERE IS A BUG WITH UPDATING THE pEARN FIELDS
			$pointArr[] = $_POST["'" . $i . "'"];
		}
		$result->points = $pointArr;
		
		if ($_POST['isGroupReview']) {
			$dbInt->submitGroupReview($result);
		}
		else {
			$dbInt->submitUserReview($result);
		}
	}
	
	//bool for input determining which review to upload
	$isGroupReview = 0;
	
	if (isset($_POST['gReview'])) {
		//group review is selected
		$isGroupReview = 1;
	}
	//group review wasn't selected/default don't change isGroupReview
	
	//holds the relevant row from the proper review channel
	//initialized as false in case uReviews/gReviews are false
	$row = FALSE;
?>

<div class="container-fluid">
	<div class="panel panel-default" style="margin-top:5px;">
		<div class="panel-body" id="test">
			<div class="row" style="margin-top:15px;">
				<div class="col-md-3" style="float:left;">
					<div class="feedback-side-menu">
						<div style="padding-bottom:2px;">
<<<<<<< HEAD
							<button type="button" class="btn btn-default feedback-button-fixes" id="single">
								Single Reviews (<?php 
									require_once('classes/dbInterface.php');
									$dbInt = new DbInterface();
<<<<<<< HEAD
									$uReviews = $dbInt->getUserReviews($_SESSION['id']);
									$uReviewsArray = array();
									foreach ($uReviews->fetch() as $row) {
										array_push($uReviewsArray, $row);
									}
									//echo the number of rows in userReviews
									echo $uReviews->rowCount();
=======
									$reviews = $dbInt->getUserReviews($_SESSION['id']);
									echo $reviews->rowCount();
>>>>>>> parent of 74ee3ed... added group review reading from DB
								?>)
							</button>
							<input type='hidden' value='<?php print_r($uReviewsArray); ?>' id='uReviews' />
						</div>
						<div style="padding-top:2px;">
							<button type="button" class="btn btn-default feedback-button-fixes" id="group">
								Group Reviews
							</button>
							<input type='hidden' value='<?php echo json_encode($gReviews); ?>' id='gReviews' />
=======
							<form action="?controller=cprm&action=feedback" method="post">
								<button name="uReview" type="submit" class="btn btn-default feedback-button-fixes" id="single">
									Single Reviews (<?php 
										
										//get number of user reviews
										$uReviews = $dbInt->getUserReviews($_SESSION['id'], $_SESSION['course']->id);
										
										//this makes sure there are rows to display
										if ($uReviews != FALSE) {
											if(!$isGroupReview) {
											
												$row = $uReviews->fetch();
												
											}
		
											//echo the number of rows in userReviews
											echo $uReviews->rowCount();
										}
										
										else {
											echo "0";
										}
											
									?>)
								</button>
							</form>
						</div>
						<div style="padding-top:2px;">
							<form action="?controller=cprm&action=feedback" method="post">
								<button name="gReview" type="submit" class="btn btn-default feedback-button-fixes" id="group">
									Group Reviews (<?php
									$gReviews = $dbInt->getGroupReviews($_SESSION['id'], $_SESSION['course']->id);
									
									if ($gReviews != FALSE) {
										if ($isGroupReview) {
											
											$row = $gReviews->fetch();
										}
							
										echo $gReviews->rowCount();
									}
									
									else {
										echo "0";
									}
									?>)
								</button>
							</form>
>>>>>>> f572cd8cba815f5c44723d09bdde9c5f91831acb
						</div>
					</div>
				</div>
				<?php
					//this is responsible for setting pre-review information
					if ($row != FALSE) {
						//pull and ready the first user review as default
						$review = $row;
						
						//get number of fields used for review for loop
						$fieldsLength = $review['fieldsUsed'];
					
				?>
				<h4>Review for: 
				<?php
					if ($isGroupReview) {
						//add in group number and names
						echo "Group..."; 
					} 
					else {
						$result = $dbInt->getUserFromId($row['reviewFor']); 
						echo $result['name'];
					}
				?></h4>
				<form action="?controller=cprm&action=feedback" method="post">
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
											echo "<td><input name='" . $i . "' type='text' style='width:20%' class='form-control' value='" . $review['pEarn' . $i] . "' /></td>";
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
					<input name='isGroupReview' type="hidden" value='<?php echo $isGroupReview; ?>' />
					<input name='fieldsUsed' type="hidden" value='<?php echo $fieldsLength; ?>' />
					<!-- holds primary key -->
					<input name='reviewPrimary' type='hidden' value='<?php echo $row['reviewName']; ?>' />
					<button name='reviewSubmit' type='submit' class='btn btn-default'>Submit</button>
				</form>
				<?php } ?>
				<?php if ($row == FALSE) { ?>
					<h2>No reviews to be completed</h2>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
