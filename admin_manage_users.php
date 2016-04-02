<?php

	$page_title = "Manual update Winners";
	
	include("includes/admin_header.php");
	
	if($_SESSION["login_user"]){
		
	}
	else{
		header("location: loginpage.php");
	}
	
?>
	<!-- Insert form here -->
    <div class="center_content">
      <div class="center_title_bar">Manage Users</div>
	   <form action="php_func\functions.php" method="post">
		<table width="90%" align="center">
			<tr>
				<td><label for="lblusername" class="register_label">Name:</label></td>
				<td><input type="text" name="username" class="register_input" required placeholder="Type the name here" value="<?php echo $_POST["username"];?>"></td>
			</tr>
			
			<tr>
				<td><label for="lblemail"  class="register_label">Email:</label></td>
				<td><input type="email" name="email" class="register_input" required placeholder="example@example.com" value="<?php echo $_POST["email"];?>"><br></td>
			</tr>
			
			<tr>
				<td><label for="lblpassword"  class="register_label">Password:</label></td>
				<td><input type="password" name="password" class="register_input" required placeholder="********" value="<?php echo $_POST["password"];?>"></td>
			</tr>
			
			<tr>
				<td><label for="lblconfirmpassword"  class="register_label">Confirm Password:</label></td>
				<td><input type="password" name="confirmpassword" class="register_input" required placeholder="********" value="<?php echo $_POST["confirmpassword"];?>"></td>
			</tr>
			
			<tr>
				<td><label for="lbladdress"  class="register_label">Address:</label></td>
				<td><textarea name="address" class="register_input2" required placeholder="Type the address here"><?php echo $_POST["address"];?></textarea></td>
			</tr>
			
			<tr>
				<td colspan="2" align="center" ><input type="submit", name="admin_insert_user_submit" value="Insert"></td>
			</tr>
		</table>
				
				<?php 
				
					if($_SESSION["admin_Insert_User_Result"] != ""){
						echo $_SESSION["admin_Insert_User_Result"];
						$_SESSION["admin_Insert_User_Result"] = "";
					}
					
					if($_SESSION["admin_Update_User_Result"] != ""){
						echo $_SESSION["admin_Update_User_Result"];
						$_SESSION["admin_Update_User_Result"] = "";
					}
					
					if($_SESSION["admin_Delete_User_Result"] != ""){
						echo $_SESSION["admin_Delete_User_Result"];
						$_SESSION["admin_Delete_User_Result"] = "";
					}
				?>
		</form>

		<div class="center_title_bar">List of Users</div>
		<?php
			include_once 'php_func\functions.php';
			$result = select_All_Public_Users();
				echo "<table class=\"rwd-table\">";
				echo "<tr><th>Name</th><th>Email</th><th>Address</th><th>Display Picture</th>   </tr>"; 

				while(list($a,$b,$c,$d,$e)=pg_fetch_array($result))
				{

				echo "<tr>";    echo "<td>".$a."</td>";

				echo "<td>".$b."</td>";

				echo "<td>".$d."</td>";

				echo "<td>".$e."</td>";

				echo "<td><a href='admin_edit_user.php?email=$b' class=\"submit_btn\">Edit</a>    <a href='admin_remove_user.php?email=$b' class=\"submit_btn\">Delete</a></td>";

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
