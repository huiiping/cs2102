<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Manage Items</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="style.css" />
<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="iecss.css" />
<![endif]-->
<script type="text/javascript" src="js/boxOver.js"></script>
<?php 
	session_start();
?>
<?php
if($_SESSION["login_user"] && $_SESSION["logon_type"] == "ADMIN") {
		?>
		
		<?php
		}
		else {
			header("location: loginpage.php");
		}
?>
</head>
<body>
<div id="main_container">
  <div id="header">
    <div class="top_right">
      <div class="big_banner"> <a href="#"><img src="images/banner728.jpg" alt="" border="0" /></a> </div>
    </div>
    <div id="logo"> <a href="#"><img src="images/logo.png" alt="" border="0" width="182" height="85" /></a> </div>
  </div>
  <div id="main_content">
    <div id="menu_tab">
      <ul class="menu">
        <li><a href="#" class="nav"> Home </a></li>
        <li class="divider"></li>
        <li><a href="logout.php" class="nav">Logout</a></li>
        <li class="divider"></li>
      </ul>
    </div>
    <!-- end of menu tab -->
    <div class="crumb_navigation"> Navigation: <span class="current">Manage Items</span> </div>
    <div class="left_content">
      <div class="title_box">Menu</div>
      <ul class="left_menu">
        <li class="odd"><a href="admin_manage_users.php">Manage Users</a></li>
        <li class="odd"><a href="admin_manage_items.php">Manage Items</a></li>
        <li class="even"><a href="admin_search_info.php">Search Information</a></li>
      </ul>
      <div class="border_box">
      </div>
    </div>
    <!-- end of left content -->
	<!-- Insert form here -->
    <div class="center_content">
      <div class="center_title_bar">New Item</div>
	   <form action="php_func\functions.php" method="post">
	   
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
				<td colspan="2" align="center" ><input type="submit", name="admin_insert_item_submit" value="Inserts"></td>
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
		<div class="center_title_bar">List of Items</div>
		<?php
			$result = select_All_Items();
				echo "<table class=\"rwd-table\">";
				echo "<tr><th>Name</th><th>Description</th><th>Availability</th><th>Loan Type</th><th>Category</th><th>Image</th><th>Owner Name</th>  </tr>"; 

				while(list($id,$iName,$iDesc,$iAvail,$iLoanT, $iCat, $iImage, $iOwner)=pg_fetch_array($result))
				{

				echo "<tr>";    echo "<td>".$iName."</td>";

				echo "<td>".$iDesc."</td>";

				echo "<td>";
				if ($iAvail == "t"){
					echo "YES";
				}else{
					echo "NO";
				}
				echo "</td>";

				echo "<td>".$iLoanT."</td>";
				
				echo "<td>".$iCat."</td>";
				
				echo "<td>";
				echo '<img src="images/';
				echo $iImage;
				echo '" alt="" border="0" width="100" height="100" />';
				echo "</td>";
				
				echo "<td>".$iOwner."</td>";

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
  <div class="footer">
    <div class="left_footer"> <img src="images/footer_logo.png" alt="" width="89" height="42"/> </div>
    <div class="center_footer"> Template name. All Rights Reserved 2008<br />
      <a href="http://csscreme.com"><img src="images/csscreme.jpg" alt="csscreme" title="csscreme" border="0" /></a><br />
      <img src="images/payment.gif" alt="" /> </div>
    <div class="right_footer"> <a href="#">home</a> <a href="#">about</a> <a href="#">sitemap</a> <a href="#">rss</a> <a href="#">contact us</a> </div>
  </div>
</div>
<!-- end of main_container -->
</body>
</html>
