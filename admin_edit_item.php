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
      <div class="center_title_bar">Update User Details</div>
		<?php 
			$result = select_A_Item($_GET['itemID']);
			
			$rowReceived=pg_fetch_array($result);
			extract($_POST); 
			if($upd)
			{
				admin_update_Item_Details($_GET['itemID'], $itemname, $itemDesc, $formItemCategory, $shareType, $formOwners);
				header('location:admin_manage_items.php');
			}
		?>
	   <form method="post" enctype="multipart/form-data">
			<table>
			<tr>
				<td><label for="lblCategory" class="register_label">Category:</label></td>
				<td>
					<select name="formItemCategory" class="optionL" required>
						<option value="">Chose one..</option>
						<?php
							include_once 'php_func\functions.php';
							$result = select_All_Categories();
			
							if(pg_num_rows($result) > 0){
								while ($row = pg_fetch_row($result)){
									echo '<option value="' . $row[0] . '"';
									if($rowReceived['category'] == $row[0]){
										echo 'selected';
									} 
									echo '>' . $row[1] . '</option>';
								}
							}
							
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="lblItemName" class="register_label">Name:</label></td>
				<td>
					<input type="text" name="itemname" size="25" required placeholder="Type the item name here" class="register_input" value="<?php echo $rowReceived['item_name'];?>">
				</td>
			</tr>
			<tr>
				<td><label for="lblDescription" class="register_label">Description:</label></td>
				<td>
					<textarea name="itemDesc" required placeholder="Type the description here" class="register_input2"><?php echo $rowReceived['description'];?></textarea>
				</td>
			</tr>
			<tr>
				<td><label for="lblLoanType" class="register_label">Share it for free or for an amount:</label></td>
				<td>
					<input type="radio" name="shareType"
					<?php echo (string)$rowReceived['loansetting'] == "BID" ?  "CHECKED" : "";?>
					value="BID">Bid to win
					<input type="radio" name="shareType"
					<?php echo (string)$rowReceived['loansetting'] == "SHARE" ?  "CHECKED" : "";?>
					 value="SHARE">Free
				</td>
			</tr>
			<tr>
				<td><label for="lblOwner" class="register_label">Owner:</label></td>
				<td>
					<select name="formOwners" required class="optionL">
						<option value="">Select one..</option>
						<?php
							$result = select_All_Public_Users();
							if(pg_num_rows($result) > 0){
								while ($row = pg_fetch_row($result)){
									echo '<option value="' . $row[1] . '"';
									if($rowReceived['owner'] == $row[1]){
										echo 'selected';
									} 
									echo '>' . $row[0] . '</option>';
								}
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" ><input type="submit" value="Update" name="upd"/>
				<input type="button" name="cancel" value="Cancel" onclick="window.location='admin_manage_items.php'" />
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
