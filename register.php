<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Registration</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="style.css" />
<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="iecss.css" />
<![endif]-->
<script type="text/javascript" src="js/boxOver.js"></script>
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
        <?php
			if($_SESSION["login_user"]) {
				echo '<li><a href="logout.php" class="nav">Logout</a></li>';
			}
			else{
				echo '<li><a href="loginpage.php" class="nav">Login</a></li>';
			}
		?>
        <li class="divider"></li>
        <li><a href="register.php" class="nav">Sign Up</a></li>
        <li class="divider"></li>
      </ul>
    </div>
	<div class="center_content">
	  <div class="center_title_bar">User Registration</div>
	  <center>
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
	  </center>
	</div>
	<!-- end of center content -->
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
