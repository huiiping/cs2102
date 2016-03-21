<?php

	$page_title = "Registration";
	
	include("includes/header.php");
?>
	<div class="center_content">
	  <div class="center_title_bar">User Registration</div>
		<form action="register.php" method="post">
			<table align="center"> 
			  <tr>
				<td><label class="register_label">Username: </label></td>
				<td><input type="text" name="name" class="register_input" 
					value="<?php echo $_POST['name']; ?>" required /></td>
			  </tr>
			  <tr>
				<td><label class="register_label">Email Address: </label></td>
				<td><input type="email" name="email" class="register_input" 
					value="<?php echo $_POST['email']; ?>" required /></td>
			  </tr>
			  <tr>
				<td><label class="register_label">Residential Address: </label></td>
				<td><textarea name="address" class="register_input2" required><?php echo $_POST['address']; ?></textarea></td>
			  </tr>
			  <tr>
				<td><label class="register_label">Password: </label></td>
				<td><input type="password" name="password" class="register_input" required /></td>
			  </tr>
			  <tr>
				<td><label class="register_label">Confirm Password: </label></td>
				<td><input type="password" name="cpassword" class="register_input" required /></td>
			  </tr>
			  <tr>
				<td></td>
				<td height="100px" align="center">
				  <input type="submit" name="submit" value="Confirm">
				  <input type="button" name="cancel" onclick="window.location.href='loginpage.php'" value="Cancel"></td>
			  </tr>
			</table>

<?php
include_once('php_func\registration.php');
?>

		</form>
	</div>
	<!-- end of center content -->
<?php

  include("includes/footer.php");

?>