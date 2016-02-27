<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
session_start();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Carou-Share</title>
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
        <li><a href="register.php" class="nav">Sign Up</a></li>
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
    <div class="center_content">
      <div class="oferta">
        <div class="oferta_details">
          <div class="oferta_title">Welcome to Carou-Share</div>
          <div class="oferta_text"> We would like to share our items to our friends including around the neighbourhood. To do that, we designed this site to cater your needs to put your items in good use.  </div>
          <a href="#" class="prod_buy">details</a> </div>
      </div>
      <div class="center_title_bar">Latest Products</div>
	  
	  
	  
		<?php
		
		include 'php_func\functions.php';
		
		
		$result = select_All_Items();
		
		if(pg_num_rows($result) > 0){
			while(list($id,$iName,$iDesc,$iAvail,$iLoanT, $iCat, $iImage, $iOwner)=pg_fetch_array($result)){
				echo '<div class="prod_box">' . '<div class="center_prod_box">' . '<div class="product_title"><a href="#">' . $iName . '</a></div>';
				echo '<div class="product_img"><a href="#"><img src="images/' . $iImage . '" border="0" width="100" height="100" /></a></div>';
				echo '</div></div>';
			}
		}
		else{
			echo 'Sorry, no item found.';
		}
	  ?>

    </div>
    <!-- end of center content -->
    <div class="right_content">
      <div class="title_box">Search</div>
      <div class="border_box">
        <input type="text" name="newsletter" class="newsletter_input" value="keyword"/>
        <a href="#" class="join">search</a> </div>
      <div class="shopping_cart">
        <div class="title_box">Shopping cart</div>
        <div class="cart_details"> 3 items <br />
          <span class="border_cart"></span> Total: <span class="price">350$</span> </div>
        <div class="cart_icon"><a href="#"><img src="images/shoppingcart.png" alt="" width="35" height="35" border="0" /></a></div>
      </div>
      <div class="title_box">What’s new</div>
      <div class="border_box">

      </div>
      <div class="title_box">Manufacturers</div>
      <ul class="left_menu">
        <li class="odd"><a href="#">Bosch</a></li>
        <li class="even"><a href="#">Samsung</a></li>
        <li class="odd"><a href="#">Makita</a></li>
        <li class="even"><a href="#">LG</a></li>
        <li class="odd"><a href="#">Fujitsu Siemens</a></li>
        <li class="even"><a href="#">Motorola</a></li>
        <li class="odd"><a href="#">Phillips</a></li>
        <li class="even"><a href="#">Beko</a></li>
      </ul>
      <div class="banner_adds"> <a href="#"><img src="images/bann1.jpg" alt="" border="0" /></a> </div>
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
