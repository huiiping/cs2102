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
    <?php

	include("includes/footer.php");

	?>
