<!DOCTYPE html>
<?php
	$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=p@ssword")
	or die('Could not connect:' . pg_last_error());
	session_start();
?>
<html>
<head>
<title><?php echo $page_title; ?></title>
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
        <li><a href="/" class="nav"> Home </a></li>
        <li class="divider"></li>
		<?php
			if($_SESSION["login_user"]) {
				echo '<li><a href="mylistings.php" class="nav">My Listing</a></li>';
				echo '<li class="divider"></li>';
			}
		?>
        <li><a href="mybiditems.php" class="nav">Bidding</a></li>
        <li class="divider"></li>
		<?php
			if($_SESSION["login_user"]) {
				echo '<li><a href="additem.php" class="nav">Add Item</a></li>';
				echo '<li class="divider"></li>';
			}
		?>
		<?php
			if($_SESSION["login_user"]) {
				echo '<li><a href="logout.php" class="nav">Logout</a></li>';
			}
			else{
				echo '<li><a href="loginpage.php" class="nav">Login</a></li>';
			}
		?>
		<li class="divider"></li>
        <?php
			if($_SESSION["login_user"]) {
				echo '<li><a href="updateprofile.php" class="nav">Update Profile</a></li>';
			} else {
				echo '<li><a href="register.php" class="nav">Sign Up</a></li>';
			}
		?>
		<li class="divider"></li>
      </ul>
    </div>
    <!-- end of menu tab -->
    <div class="crumb_navigation"> Navigation: <span class="current">Home</span>
			<?php
			if($_SESSION["login_user"]) {
				echo '      Signed in as ' . $_SESSION["login_name"] ;
			}
		?>
	</div>
	<div class="left_content">
      <div class="title_box">Categories</div>
      <ul class="left_menu">
        <li class="odd"><a href="#">Books</a></li>
        <li class="even"><a href="#">Tools</a></li>
        <li class="odd"><a href="#">Furnitures</a></li>
        <li class="even"><a href="#">Appliances</a></li>
		<li class="odd"><a href="#">Home Maintenance</a></li>
        <li class="even"><a href="#">Personal Care</a></li>
		<li class="odd"><a href="#">Arts and Crafts</a></li>
      </ul>
      <div class="title_box">Special Products</div>
      <div class="border_box">

      </div>
      <div class="title_box">Newsletter</div>
      <div class="border_box">
        <input type="text" name="newsletter" class="newsletter_input" value="your email"/>
        <a href="#" class="join">subscribe</a> </div>
      <div class="banner_adds"> <a href="#"><img src="images/bann2.jpg" alt="" border="0" /></a> </div>
    </div>
    <!-- end of left content -->