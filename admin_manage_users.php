<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Manage Users</title>
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
    <div class="crumb_navigation"> Navigation: <span class="current">Manage Users</span> </div>
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
