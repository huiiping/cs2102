<?php

	$page_title = "Update Profile";
	
	include("includes/header.php");
?>
	<div class="center_content">
	  <div class="center_title_bar">Update Profile</div>
<?php 
	include 'php_func\functions.php';
	
	$result = select_A_User($_SESSION["login_user"]);
	
	$row=pg_fetch_array($result);
	extract($_POST);
?>
		<form action="updateprofile.php" method="post">
			<table align="center"> 
			  <tr>
				<td><label class="register_label">Username: </label></td>
				<td><input type="text" name="name" class="register_input" value="<?php echo $row['name']; ?>" required /></td>
			  </tr>
			  <tr>
				<td><label class="register_label">Residential Address: </label></td>
				<td><textarea name="address" class="register_input2" required><?php echo $row['address']; ?></textarea></td>
			  </tr>
			  
			  <tr>
				<td><label class="register_label">Current Password: </label></td>
				<td><input type="password" name="curr_password" class="register_input" required /></td>
			  </tr>
			  <tr>
				<td><label class="register_label">New Password: </label></td>
				<td><input type="password" name="new_password" class="register_input" required /></td>
			  </tr>
			  <tr>
				<td><label class="register_label">Confirm Password: </label></td>
				<td><input type="password" name="con_password" class="register_input" required /></td>
			  </tr>
			  			  
			  <tr>
				<td></td>
				<td height="100px" align="center">
				  <input type="submit" name="submit" value="Update">
				  <input type="button" name="cancel" onclick="window.location.href='index.php'" value="Cancel"></td>
			  </tr>
			</table>

<?php
	include_once('php_func\functions.php');
	
	if (isset($_POST['submit'])) { 
	
		$errormsg = "";
		$email = $row['email'];
		
		//Prompt error if email is duplicated
		$result = match_Password($email, $_POST['curr_password']);
		if (pg_num_rows($result) < 1) {
			$errormsg = "Invalid password,	";
			echo $errormsg;
		}
		
		if ($_POST['new_password'] != $_POST['con_password']) { //Prompt error if password is not matched
			$errormsg = "	Password not matched.";
			echo $errormsg;
		} 
		
		if ($errormsg == "") {
			$name = pg_escape_string($_POST['name']);
			$address = pg_escape_string($_POST['address']);
			$password = pg_escape_string($_POST['new_password']);
			
			update_User($name, $email, $password, $address);
			header("Location: /index.php");
		}
	}
?>

		</form>
	</div>
	<!-- end of center content -->
<?php

  include("includes/footer.php");

?>