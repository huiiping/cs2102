<?php

	$page_title = "Add Item";
	
	include("includes/header.php");

	if(!isset($_SESSION["login_user"])){
		header("location: loginpage.php");
		exit();
	}
	
?>
    <div class="center_content">
      <div class="center_title_bar">Add Item</div>
	   <!--Add item form>-->

      <form method="post" enctype="multipart/form-data">
				<label>Item Name:</label> <input type="text" name="itemName" id="itemName">
				<br><br>
				<label>Item Picture:</label> <input type="file" name="itemPic" id="itemPic" accept="image/*">
				<br><br>
				<label>Item Description:</label>
				<br>
				<textarea name="itemDesc" id="itemDesc" rows="5"></textarea>
				<br><br>
				<label>Item Category:</label><select name="itemCat" id="itemCat">
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
        <?php

          echo "<br><br>".$_SESSION["addItemErrorMsg"]."";

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