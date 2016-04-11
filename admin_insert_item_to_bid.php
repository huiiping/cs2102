<?php

	$page_title = "Choose Item to bid";
	
	include("includes/admin_header.php");
	
	if($_SESSION["login_user"]){
		
	}
	else{
		header("location: loginpage.php");
	}
	
?>
	<!-- Insert form here -->
    <div class="center_content">
      <div class="center_title_bar">Choose Item to bid</div>
	   <form action="php_func\functions.php" method="post" enctype="multipart/form-data">
	   
		<table width="90%" align="center">
			<tr>
				<td><label for="lblItem" class="register_label">Item:</label></td>
				<td>
					<select name="formItem" required>
						<option value="">Chose one..</option>
						<?php
							include_once 'php_func\functions.php';
							$result = select_Items_Available();
			
							if(pg_num_rows($result) > 0){
								while ($row = pg_fetch_row($result)){
									echo '<option value="' . $row[0] . '">' . $row[1] . '</option>';
								}
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="lblStartDate" class="register_label">Start Date (yyyy-MM-dd):</label></td>
				<td>
					<input type="text" name="startdate" size="25" required placeholder="Type the start date here" class="register_input" value="<?php echo $_SESSION["admin_Insert_Item_To_Bid_startDate"]; ?>">
				</td>
			</tr>
			<tr>
				<td><label for="lblBidDuration" class="register_label">Duration of the Event (in digits):</label></td>
				<td>
					<input type="text" name="bidperiod" size="25" required placeholder="Type the duration here" class="register_input" value="<?php echo $_SESSION["admin_Insert_Item_To_Bid_bidPeriod"]; ?>">
				</td>
			</tr>
			<tr>
				<td><label for="lblLoanBegin" class="register_label">Loan Start Date (yyyy-MM-dd):</label></td>
				<td>
					<input type="text" name="loanbegin" size="25" required placeholder="Type when the loan starts here" class="register_input" value="<?php echo $_SESSION["admin_Insert_Item_To_Bid_loanBegin"]; ?>">
				</td>
			</tr>
			<tr>
				<td><label for="lblLoanPeriod" class="register_label">Loan Duration (in digits):</label></td>
				<td>
					<input type="text" name="loanperiod" size="25" required placeholder="Type the loan duration here" class="register_input" value="<?php echo $_SESSION["admin_Insert_Item_To_Bid_loanPeriod"]; ?>">
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" ><input type="submit", name="admin_insert_item_to_bid_submit" value="Insert"></td>
			</tr>
			
		</table>
		<?php
			
			
			if($_SESSION["admin_Insert_Item_To_Bid_Result"] != ""){
				echo $_SESSION["admin_Insert_Item_To_Bid_Result"];
				$_SESSION["admin_Insert_Item_To_Bid_Result"] = "";
			}

			
		?>
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
