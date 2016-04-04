<?php

	$page_title = "Edit user";
	
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
			$result = select_A_User($_GET['email']);
			
			$row=pg_fetch_array($result);
			extract($_POST); 
			if($upd)
			{
				admin_update_User_Details($username, $_GET['email'], $password, $address);
				header('location:admin_manage_users.php');
			}
		?>
	   <form method="post" enctype="multipart/form-data">
			<table>
			<tr>
				<Td>Name</td>
				<td><input type="text" name="username" value="<?php echo $row['name'];?>" required/></td>
			</tr>
			<tr>
				<Td>Email</td>
				<td><input readonly="readonly" value="<?php echo $row['email'];?>" type="email" name="email" required/></td>
			</tr>
			<tr>
				<Td>Password</td>
				<td><input value="<?php echo $row['password'];?>" type="password" name="password" required/></td>
			</tr>
			<tr>
				<Td>Address</td>
				<td>
				<textarea name="address" required><?php echo $row['address'];?></textarea></td>
			</tr>

			<tr>
				<Td colspan="2" align="center">
				<input type="submit" value="Update" name="upd"/>
				<input type="button" name="cancel" value="Cancel" onclick="window.location='admin_manage_users.php'" />
				</Td>
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
