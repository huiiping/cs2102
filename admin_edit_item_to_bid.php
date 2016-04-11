<?php

	$page_title = "Edit item";
	
	include("includes/admin_header.php");
	
	if($_SESSION["login_user"]){
		
	}
	else{
		header("location: loginpage.php");
	}
	include 'php_func\functions.php';
?>
	<!-- Insert form here -->
    <div class="center_content">
      <div class="center_title_bar">Update Item to bid Details</div>
		<?php 
			$result = select_A_Unsettle_Items_to_bid($_GET['itemID']);
			$rowReceived=pg_fetch_array($result);
			extract($_POST); 
			if($upd)
			{
				update_A_Unsettle_Items_to_bid($_GET['itemID'], $startdate, $bidperiod, $loanbegin, $loanperiod);
				header('location:admin_insert_item_to_bid.php');
			}
		?>
	   <form method="post" enctype="multipart/form-data">
			<table>
			<tr>
				<td><label for="lblStartDate" class="register_label">Start Date (yyyy-MM-dd):</label></td>
				<td>
					<input type="text" name="startdate" size="25" required placeholder="Type the start date here" class="register_input" value="<?php echo $rowReceived[0]; ?>">
				</td>
			</tr>
			<tr>
				<td><label for="lblBidDuration" class="register_label">Duration of the Event (in digits):</label></td>
				<td>
					<input type="text" name="bidperiod" size="25" required placeholder="Type the duration here" class="register_input" value="<?php echo $rowReceived[1]; ?>">
				</td>
			</tr>
			<tr>
				<td><label for="lblLoanBegin" class="register_label">Loan Start Date (yyyy-MM-dd):</label></td>
				<td>
					<input type="text" name="loanbegin" size="25" required placeholder="Type when the loan starts here" class="register_input" value="<?php echo $rowReceived[2]; ?>">
				</td>
			</tr>
			<tr>
				<td><label for="lblLoanPeriod" class="register_label">Loan Duration (in digits):</label></td>
				<td>
					<input type="text" name="loanperiod" size="25" required placeholder="Type the loan duration here" class="register_input" value="<?php echo $rowReceived[3]; ?>">
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" ><input type="submit" value="Update" name="upd"/>
				<input type="button" name="cancel" value="Cancel" onclick="window.location='admin_edit_item_to_bid.php'" />
				</td>
			</tr>
			</table>
		</form>
		
		
    </div>
    <!-- end of center content -->
    <div class="right_content">
      
    </div>
    <!-- end of right content -->
  </div>
  <!-- end of main content -->
  <?php

	include("includes/admin_footer.php");

	?>
