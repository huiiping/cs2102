<?php

	$page_title = "Bid Item";
	
	include("includes/header.php");
	
	if($_SESSION["login_user"]){
		
	}
	else{
		header("location: loginpage.php");
	}
	
?>
    <div class="center_content">
      <div class="center_title_bar">Place your Bid</div>
	  
		
		<div><span id="time"></span></div>
	  
		
		<script>
		
		function startTimer(duration, display) {
			var timer = duration, minutes, seconds;
			setInterval(function () {
				day = parseInt((((timer / 60) / 60) / 24) % 24, 10)
				hr = parseInt(((timer / 60) / 60) % 24, 10);
				minutes = parseInt((timer / 60) % 60, 10);
				seconds = parseInt(timer % 60, 10);

				day = day < 10 ? "0" + day : day;
				hr = hr < 10 ? "0" + hr : hr;
				minutes = minutes < 10 ? "0" + minutes : minutes;
				seconds = seconds < 10 ? "0" + seconds : seconds;

				display.textContent = "Bidding will close in: " + day + " Days " +  hr + ":" + minutes + ":" + seconds;

				if (--timer < 0) {
					timer = 0;
				}
			}, 1000);
		}

		// window.onload = function () {
			// var fiveMinutes = 60 * 1,
				// display = document.querySelector('#time');
				// display.style.fontSize = "30px";
			// startTimer(fiveMinutes, display);
		// };

		window.onload = function () {
			var fiveMinutes = 
			<?php 
				include 'php_func\functions.php';
				$getTimeLeft = select_Item_To_Bid_TimeLeft($_GET['itemID'], $_GET['startDate']);
				list($timeLeft)=pg_fetch_array($getTimeLeft);
				echo $timeLeft;
			?>,
				display = document.querySelector('#time');
				display.style.fontSize = "30px";
			startTimer(fiveMinutes, display);
		};
		</script>
	  <?php
			
			extract($_POST); 
			if($upd)
			{
				insert_bid($_GET['itemID'], $_GET['startDate'], $_SESSION["login_user"], $currentBidAmt);
			}
			
			if($_SESSION["bid_Success"] != ""){
				echo $_SESSION["bid_Success"];
				$_SESSION["bid_Success"] = "";
			}
		?>
		<form method="post" enctype="multipart/form-data">
			<table class="rwd-table">
			<tr><th>Item</th><th>No. of bidders</th><th>Highest Bid</th><th>Your Bid</th><th></th></tr>
			<tr>
				<td>
					<?php
						echo $_GET['itemID'];
					?>
				</td>
				<td align="center">
					<?php
						$getTotalBidders = select_Current_Total_Bidders($_GET['itemID'], $_GET['startDate']);
						list($totalBidders)=pg_fetch_array($getTotalBidders);
						if($totalBidders > 0)
							echo $totalBidders;
						else
							echo "0";
					?>
				</td>
				<td align="center">
					<?php
						$getCurrentBid = select_Current_Bid($_GET['itemID'], $_GET['startDate'], $_SESSION["login_user"]);
						$getHighestBidder = select_Current_Highest_Bidder($_GET['itemID'], $_GET['startDate']);
						list($highestBid) = pg_fetch_array($getHighestBidder);
						if($highestBid > 0.0)
							echo $highestBid;
						else
							echo "0.0";
					?>
				</td>
				<td align="center">
				<?php 
					$getItemDetail = select_A_Item($_GET['itemID']);
					if(pg_num_rows($getItemDetail) > 0){
						while ($row = pg_fetch_row($getItemDetail)){
							$loanSetting = $row[4];
						}
					}
				?>
					<input <?php if($loanSetting == "BID") echo "type=\"text\""; else echo "type=\"hidden\"";?> name="currentBidAmt" size="10" required placeholder="Enter Bid" width="60px" value="<?php list($currentBid) = pg_fetch_array($getCurrentBid); echo $currentBid;?>">
				</td>

				<td colspan="2" align="center" ><input type="submit" value="Bid" name="upd"/>
				</td>
			</tr>
			</table>
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
