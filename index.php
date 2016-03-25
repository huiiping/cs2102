<?php

	$page_title = "Carou-Share";
	
	include("includes/header.php");
	
?>
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
		
		
		$result = select_Available_Bid_Items();
		
		if(pg_num_rows($result) > 0){
				while ($row = pg_fetch_row($result)){
					echo '<div class="prod_box">' . '<div class="product_title"><a href="#">' . '<img src="images/' . $row[5] . '" alt="" border="0" width="180" height="180" />' . '<div align = left>' . nl2br("\n Item: ") . $row[1] . nl2br("\n Description: ") . $row[2] . nl2br("\n Owner: ") . $row[3] . nl2br("\n Pickup Location: ") . $row[6] . nl2br("\n Return Location: ") . $row[7] . nl2br("\n Start Date: ") . date_format(date_create($row[8]), "Y/m/d") .
					"<br><br>" .
					"<td><a href='bid.php?itemID=$row[0]&startDate=$row[8]' class=\"submit_btn\">Bid</a></td>" .
					'</a></div>' . '</div></div>' ;
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
