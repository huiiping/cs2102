<?php

	$page_title = "Manage items";
	
	include("includes/admin_header.php");
	
	if($_SESSION["login_user"]){
		
	}
	else{
		header("location: loginpage.php");
	}
	
?>
	<!-- Insert form here -->
    <div class="center_content">
      <div class="center_title_bar">New Item</div>
	   <form action="php_func\functions.php" method="post" enctype="multipart/form-data">
	   
		<table width="90%" align="center">
			<tr>
				<td><label for="lblCategory" class="register_label">Category:</label></td>
				<td>
					<select name="formItemCategory" required>
						<option value="">Chose one..</option>
						<?php
							include_once 'php_func\functions.php';
							$result = select_All_Categories();
			
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
				<td><label for="lblItemName" class="register_label">Name:</label></td>
				<td>
					<input type="text" name="itemname" size="25" required placeholder="Type the item name here" class="register_input">
				</td>
			</tr>
			<tr>
				<td><label for="lblDescription" class="register_label">Description:</label></td>
				<td>
					<textarea name="itemDesc" required placeholder="Type the description here" class="register_input2"></textarea>
				</td>
			</tr>
			<tr>
				<td><label for="lblPickUpLoc" class="register_label">Pick Up Location:</label></td>
				<td>
					<textarea name="itemPickUp" required placeholder="Type the pick up location here" class="register_input2"></textarea>
				</td>
			</tr>
			<tr>
				<td><label for="lblReturnLoc" class="register_label">Return Location:</label></td>
				<td>
					<textarea name="itemReturnLoc" required placeholder="Type the return location here" class="register_input2"></textarea>
				</td>
			</tr>
			<tr>
				<td><label for="lblLoanType" class="register_label">Share it for free or for an amount:</label></td>
				<td>
					<input type="radio" name="shareType"
					<?php if (isset($share) && $share=="bid") echo "checked";?>
					value="bid">Bid to win
					<input type="radio" name="shareType"
					<?php if (isset($share) && $share=="share") echo "checked";?>
					value="share" CHECKED>Free
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
									echo '<option value="' . $row[1] . '">' . $row[0] . '</option>';
								}
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="lblImage" class"register_label">Choose an image</label></td>
				<td>
					<input type="file" name="imageToUpload" id="imageToUpload" accept="image/*">
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center" ><input type="submit", name="admin_insert_item_submit" value="Insert"></td>
			</tr>
			
		</table>
		<?php
			//$success = $_GET["message"];

			//if (isset($success)) {
				//if($success == "SUCCESS"){
					//echo 'Successfully added.';
				//}
				//else{
					//echo 'Failed to add.';
				//}
			//}
			
			if($_SESSION["admin_Insert_Item_Result"] != ""){
				echo $_SESSION["admin_Insert_Item_Result"];
				$_SESSION["admin_Insert_Item_Result"] = "";
			}
			
			if($_SESSION["admin_Update_Item_Result"] != ""){
				echo $_SESSION["admin_Update_Item_Result"];
				$_SESSION["admin_Update_Item_Result"] = "";
			}
			
			if($_SESSION["admin_Delete_Item_Result"] != ""){
				echo $_SESSION["admin_Delete_Item_Result"];
				$_SESSION["admin_Delete_Item_Result"] = "";
			}
			
		?>
		</form>
		<a href='admin_insert_item_to_bid.php' class=\"submit_btn\">Click here to add a event to bid</a>
		<div class="center_title_bar">List of Items</div>
		<?php
			$result = select_All_Items();
				echo "<table class=\"rwd-table\">";
				echo "<tr><th>Name</th><th>Description</th><th>Availability</th><th>Loan Type</th><th>Category</th><th>Image</th><th>Owner Name</th>  </tr>"; 

				while(list($id,$iName,$iDesc,$iAvail,$iLoanT, $iCat, $iImage, $iOwner)=pg_fetch_array($result))
				{

				echo "<tr>";    echo "<td align='center'>".$iName."</td>";

				echo "<td align='center'>".$iDesc."</td>";

				echo "<td align='center'>";
				if ($iAvail == "t"){
					echo "YES";
				}else{
					echo "NO";
				}
				echo "</td>";

				echo "<td align='center'>".$iLoanT."</td>";
				
				echo "<td align='center'>".$iCat."</td>";
				
				echo "<td>";
				echo '<img src="images/';
				echo $iImage;
				echo '" alt="" border="0" width="100" height="100" />';
				echo "</td>";
				
				echo "<td align='center'>".$iOwner."</td>";

				echo "<td><a href='admin_edit_item.php?itemID=$id' class=\"submit_btn\">Edit</a>    <a href='admin_remove_item.php?itemID=$id' class=\"submit_btn\">Delete</a></td>";

				echo "</tr>";    

				}

				echo "</table>";
		?>
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
