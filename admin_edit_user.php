<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Update User Particular</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="style.css" />
<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="iecss.css" />
<![endif]-->
<script type="text/javascript" src="js/boxOver.js"></script>
<?php include 'php_func\functions.php'; ?>
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
      <div class="languages">
        <div class="lang_text">Languages:</div>
        <a href="#" class="lang"><img src="images/en.gif" alt="" border="0" /></a> <a href="#" class="lang"><img src="images/de.gif" alt="" border="0" /></a> </div>
      <div class="big_banner"> <a href="#"><img src="images/banner728.jpg" alt="" border="0" /></a> </div>
    </div>
    <div id="logo"> <a href="#"><img src="images/logo.png" alt="" border="0" width="182" height="85" /></a> </div>
  </div>
  <div id="main_content">
    <div id="menu_tab">
      <ul class="menu">
        <li><a href="#" class="nav"> Home </a></li>
        <li class="divider"></li>
        <li><a href="mylistings.php" class="nav">My Listing</a></li>
        <li class="divider"></li>
        <li><a href="mybiditems.php" class="nav">Bidding</a></li>
        <li class="divider"></li>
		<li><a href="additem.php" class="nav">Add Item</a></li>
        <li class="divider"></li>
        <li><a href="logout.php" class="nav">Logout</a></li>
        <li class="divider"></li>
        <li><a href="register.php" class="nav">Sign Up</a></li>
        <li class="divider"></li>
      </ul>
    </div>
    <!-- end of menu tab -->
    <div class="crumb_navigation"> Navigation: <span class="current">Update User Particular</span> </div>
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
