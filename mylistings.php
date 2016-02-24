<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
session_start();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Tools Shop</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="style.css" />
<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="iecss.css" />
<![endif]-->
<script type="text/javascript" src="js/boxOver.js"></script>



<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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
<li class="divider"></li>
	<li><a href="mylistings.php" class="nav">My Listings </a></li>

      </ul>
    </div>
    <!-- end of menu tab -->
    <div class="crumb_navigation"> Navigation: <span class="current">My Listings</span> </div>
    <div class="left_content">
      <div class="title_box">Categories</div>
      <ul class="left_menu">
        <li class="odd"><a href="#">Book</a></li>
        <li class="even"><a href="#">Tools</a></li>
        <li class="odd"><a href="#">Furniture</a></li>
        <li class="even"><a href="#">Appliance</a></li>
      </ul>
      <div class="title_box">Special Products</div>
      <div class="border_box">
        <div class="product_title"><a href="#">Makita 156 MX-VL</a></div>
        <div class="product_img"><a href="#"><img src="images/p1.jpg" alt="" border="0" /></a></div>
        <div class="prod_price"><span class="reduce">350$</span> <span class="price">270$</span></div>
      </div>
      <div class="title_box">Newsletter</div>
      <div class="border_box">
        <input type="text" name="newsletter" class="newsletter_input" value="your email"/>
        <a href="#" class="join">subscribe</a> </div>
      <div class="banner_adds"> <a href="#"><img src="images/bann2.jpg" alt="" border="0" /></a> </div>
    </div>
    <!-- end of left content -->


    <div class="center_content">
		<ul class="nav nav-pills">
			<li class="active"><a href="mylistings.php">Personal Items</a></li>
			<li><a href="myborroweditems.php">Borrowed Items</a></li>
			<li><a href="mybiditems.php">Bid Items</a></li>
			
		</ul>
		<br>
<div class="center_title_bar">Personal Items - AVAILABLE</div>

		<?php
		if($_SESSION["login_user"]) {
		?>
		Welcome <?php echo $_SESSION["login_name"]; ?>. 
		
		<?php
		}
		else {
			header("location: loginpage.php");
		}
		?>
		
		<?php
		include 'php_func\functions.php';
		$result = select_Available_Items($_SESSION["login_user"]);
		
		if(pg_num_rows($result) > 0){
			while ($row = pg_fetch_row($result)){
				echo '<div class="prod_box">' . '<div class="center_prod_box">' . '<div class="product_title"><a href="#">' . '<img src="images/' . $row[4] . '" alt="" border="0" width="200" height="200" />' . '<div align = left>' . nl2br("\n Item Name: ") . $row[0] . nl2br("\n Description: ") . $row[1] . nl2br("\n Category: ") . $row[2] . nl2br("\n Owner: ") . $row[3] .
				'</a></div>' . '</div></div>' ;
			}
		}
		else{
			echo 'Sorry, no item found.';
		}
	  ?>


<div class="center_title_bar">Personal Items - ON LOAN</div>
		<?php
		include 'php_func\functions.php';
		$result = select_OnLoan_Items();
		
		if(pg_num_rows($result) > 0){
			while ($row = pg_fetch_row($result)){
				echo '<div class="prod_box">' . '<div class="center_prod_box">' . '<div class="product_title"><a href="#">' . '<img src="images/' . $row[4] . '" alt="" border="0" width="200" height="200" />' . '<div align = left>' . nl2br("\n Item Name: ") . $row[0] . nl2br("\n Description: ") . $row[1] . nl2br("\n Category: ") . $row[2] . nl2br("\n Owner: ") . $row[3] .
				'</a></div>' . '</div></div>' ;
			}
		}
		else{
			echo 'Sorry, no item found.';
		}
	  ?>

	</div>
	
	<div class="center_title_bar">History of Loaned Items</div>
		<?php
		include 'php_func\functions.php';
		$result = select_OnLoan_Items();
		
		if(pg_num_rows($result) > 0){
			while ($row = pg_fetch_row($result)){
				echo '<div class="prod_box">' . '<div class="center_prod_box">' . '<div class="product_title"><a href="#">' . '<img src="images/' . $row[4] . '" alt="" border="0" width="200" height="200" />' . '<div align = left>' . nl2br("\n Item Name: ") . $row[0] . nl2br("\n Description: ") . $row[1] . nl2br("\n Category: ") . $row[2] . nl2br("\n Owner: ") . $row[3] .
				'</a></div>' . '</div></div>' ;
			}
		}
		else{
			echo 'Sorry, no item found.';
		}
	  ?>

	</div>
<!-- end of center content -->


</body>
</html>
