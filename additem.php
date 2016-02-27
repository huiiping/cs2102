

<?php

	$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=p@ssword")
	or die('Could not connect:' . pg_last_error());
	session_start();

	$page_title = "Add Item";
	
	include("includes/header.php");


	if(!isset($_SESSION["login_user"])){
		header("location: loginpage.php");
		exit();
	}
	
?>


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
        <li><a href="#" class="nav">Products</a></li>
        <li class="divider"></li>
        <li><a href="#" class="nav">Specials</a></li>
        <li class="divider"></li>
        <li><a href="#" class="nav">My account</a></li>
        <li class="divider"></li>
        <li><a href="#" class="nav">Sign Up</a></li>
        <li class="divider"></li>
        <li><a href="#" class="nav">Shipping </a></li>
        <li class="divider"></li>
        <li><a href="contact.html" class="nav">Contact Us</a></li>
        <li class="divider"></li>
        <li><a href="details.html" class="nav">Details</a></li>
      </ul>
    </div>
    <!-- end of menu tab -->
    <div class="crumb_navigation"> Navigation: <span class="current">Home</span> </div>
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
      <div class="center_title_bar">Add Item</div>
	   <!--Add item form>-->

      <form action="additem.php" method="post">
				Item Name: <input type="text" name="itemName" id="itemName">
				<br><br>
				Item Picture: <input type="file" name="itemPic" id="itemPic">
				<br><br>
				Item Description:
				<br>
				<textarea name="itemDesc" id="itemDesc" rows="5"></textarea>
				<br><br>
				<select name="itemCat" id="itemCat"> <option value="">Item Category</option> 
  				<?php
  					$query = 'SELECT DISTINCT name, catid FROM category';
  					$result = pg_query($query) or die('Query failed: ' . pg_last_error());
  					while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
  						$c_id = $row['catid'];
  						echo "<option value=\"".$c_id."\">".$row['name']."</option><br>";
  					}
  					pg_free_result($result);
  				?>
				</select>		
				<br><br>
				<input type="radio" name="loanSetting" id="loanSetting_share" value="SHARE">Share
				<input type="radio" name="loanSetting" id="loanSetting_rent" value="BID">Bid
				<br><br>
				<input type="submit" name="formSubmit" value="Submit" >
         <?php
          include_once('php_func\additem.php');
        ?>
			</form>
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
        <div class="product_title"><a href="#">Motorola 156 MX-VL</a></div>
        <div class="product_img"><a href="#"><img src="images/p2.jpg" alt="" border="0" /></a></div>
        <div class="prod_price"><span class="reduce">350$</span> <span class="price">270$</span></div>
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