<?php

	$page_title = "Search Information";
	
	include("includes/admin_header.php");
	
	if($_SESSION["login_user"]){
		
	}
	else{
		header("location: loginpage.php");
	}

?>
	<!-- Insert form here -->
	<div class="center_content">
	  <div class="center_title_bar">Search Information</div>
		<center>
		<select name="statisticList" id="statisticList" required>
			<option value="" selected>Choose one</option>
			<option value="0">Bidding Result Statistic</option>
			<option value="1">Item Statistic</option>
			<option value="2">User Statistic</option>			
		</select>
		<div id="biddingResult" style="display:none;"><br>
			<h2>Bidding Results Statistic</h2>
			<table class="rwd-table" border="2">
<?php
	include_once 'php_func\statistics.php';
	
	//display number of bidders for each item, ranked according to item name (A-Z), 
	//date of bid (latest to earlier) and highest to lowest bids for each item
	$result = bidding_Results(); 
	
	echo "<tr><th>Item to Bid</th><th>Name of Bidder</th><th>Bid Start Date</th>
		  <th>Bid End Date</th><th>Bid Amount (H-L)</th></tr>";
	
	while(list($iItem,$uName,$bStartDate,$bEndDate,$bAmt) = pg_fetch_array($result))
	{
		echo "<tr>"; 
		echo "<td>".$iItem."</td>";
		echo "<td>".$uName."</td>";		
		echo "<td>".$bStartDate."</td>";		
		echo "<td>".$bEndDate."</td>";		
		echo "<td>".$bAmt."</td>";
		echo "</tr>";
	}
?>
			</table>
		</div>
		<div id="itemStatistic" style="display:none;"><br>
		<div class="center_title_bar">Item Statistic</div>
			<table class="rwd-table" border="2">			
<?php
	include_once 'php_func\statistics.php';
	
	//display item statistic
	$result = item_Statistic(); 
	
	echo "<tr><th>Name of Category</th><th>Name of Item</th><th>Total Number of Item</th><th>Total Number of Bid</th></tr>";
	
	while(list($cName) = pg_fetch_array($result))
	{
		echo "<tr>"; 
		echo "<td>".$cName."</td>";
		
		//display total number of items for each category
		$result2 = item_Statistic_All($cName);
		
		while(list($iTotal) = pg_fetch_array($result2)) {
			echo "<td></td>";
			echo "<td>".$iTotal."</td>";
			echo "<td></td>";
		}
		echo "</tr>";
		
		//display name of item from each category
		$result2 = cat_Statistic_Item($cName);
		
		while(list($iName) = pg_fetch_array($result2)) {
			echo "<tr>";
			echo "<td></td>";
			echo "<td>".$iName."</td>";
			
			//display total number of bids for each item
			$result3 = cat_Statistic_Bid($iName);
			
			while(list($bNum) = pg_fetch_array($result3)) {
				echo "<td></td>";
				echo "<td>".$bNum."</td>";
			}
			echo "</tr>";
		}
		echo "<tr><td></td><td></td><td></td><td></td></tr>";
	}
?>
			</table><br>
		<div class="center_title_bar">Item that has More than 1 Bid</div>
			<table class="rwd-table" border="2">			
<?php
	include_once 'php_func\statistics.php';
	
	//display item that has 1 or more bid
	$result = item_Statistic_Bid(); 
	//insert_Bid();
	echo "<tr><th>Name of Item</th></tr>";
	
	while(list($iName) = pg_fetch_array($result))
	{
		echo "<tr>"; 
		echo "<td>".$iName."</td>";
		echo "</tr>";
	}
?>
			</table><br>
		<div class="center_title_bar">Loan Statistic</div>
			<table class="rwd-table" border="2">			
<?php
	include_once 'php_func\statistics.php';
	
	//display loan statistic
	$result = loan_Statistic(); 
	
	echo "<tr><th>Name of Item</th><th>Name of Category</th>
		  <th>Item Loan Setting</th><th>Name of Owner</th>
		  <th>Pickup Location</th><th>Return Location</th>
		  <th>Name of Borrower</th></tr>";
		  
	while(list($iName, $cName, $iSet, $iPickup, $iReturn, $uBorr) = pg_fetch_array($result))
	{
		echo "<tr>"; 
		echo "<td>".$iName."</td>";
		echo "<td>".$cName."</td>";
		echo "<td>".$iSet."</td>";
		
		//display name of owner of the item loan
		$result2 = loan_Statistic_Owner($iName);
		
		while(list($uOwner) = pg_fetch_array($result2)) {
			echo "<td>".$uOwner."</td>";
		}
		echo "<td>".$iPickup."</td>";
		echo "<td>".$iReturn."</td>";
		echo "<td>".$uBorr."</td>";
		echo "</tr>";
	}
?>
			</table><br>
		</div>
		<div id="userStatistic" style="display:none;"><br>
		<div class="center_title_bar">Users Loan Statistic</div>
			<table class="rwd-table" border="2">
<?php
	include_once 'php_func\statistics.php';
	
	//display users statistic
	$result = users_Statistic(); 
	
	echo "<tr><th>Name of User</th><th>Number of Items</th>
		  <th>Number of Items on Loan</th><th>Number of Items Borrowed</th>
		  <th>Number of Bids</th><th>Number of Failed Bids</th></tr>";
	
	while(list($uName) = pg_fetch_array($result))
	{
		echo "<tr>"; 
		echo "<td>".$uName."</td>";
		
		//display total number of items that the user has
		$result2 = users_Statistic_Items($uName);
		
		while(list($iTItem) = pg_fetch_array($result2)) {
			echo "<td>".$iTItem."</td>";
		}
		
		//display total number of loan that the user has
		$result2 = users_Statistic_Loan($uName);
		
		while(list($lTLoan) = pg_fetch_array($result2)) {
			echo "<td>".$lTLoan."</td>";
		}
		
		//display total number of item that the user has borrowed
		$result2 = users_Statistic_Borrowed($uName);
		
		while(list($lTBorr) = pg_fetch_array($result2)) {
			echo "<td>".$lTBorr."</td>";
		}
		
		//display total number of bid that the user placed
		$result2 = users_Statistic_Bids($uName);
		
		while(list($bTBid) = pg_fetch_array($result2)) {
			echo "<td>".$bTBid."</td>";
		}
		
		//display total number of failed bid that the user has
		$result2 = users_Statistic_Failed($uName);
		
		while(list($bFailed) = pg_fetch_array($result2)) {
			echo "<td>".$bFailed."</td>";
		}
		echo "</tr>";
	}
?>
			</table><br>
		<div class="center_title_bar">Users Successful Bids</div>
			<table class="rwd-table" border="2">
<?php
	include_once 'php_func\statistics.php';
	
	//display users bid statistic
	$result = users_Bid_Successful(); 
	
	echo "<tr><th>Name of User</th><th>Name of Item</th><th>Bid Amount</th></tr>";
	
	$sname = "";
	while(list($uName, $iItem, $bAmt) = pg_fetch_array($result))
	{
		if ($sname != $uName) {
			$sname = $uName;
			
			//display total number of bid the user has placed
			$result2 = users_Bid_TSuccessful();
			
			while(list($uName2, $bTotal) = pg_fetch_array($result2)) 
			{
				if ($uName2 == $uName) {
					echo "<tr>";
					echo "<td>Total for ".$uName2."</td>";
					echo "<td></td>";
					echo "<td align=\"right\">".$bTotal."</td>";
					echo "</tr>";
				}
			}
		}
		echo "<tr>"; 
		echo "<td>".$uName."</td>";
		echo "<td>".$iItem."</td>";
		echo "<td>".$bAmt."</td>";
		echo "</tr>";
	}
?>
			</table><br>
		<div class="center_title_bar">Users who Bid All Items Available for Bidding</div>
			<table class="rwd-table" border="2">
<?php
	include_once 'php_func\statistics.php';
	
	//display users who have bid for all available biddable items
	$result = users_Bid_All_Item(); 
	
	echo "<tr><th>Name of User</th></tr>";
	
	while(list($uName) = pg_fetch_array($result))
	{
		echo "<tr>"; 
		echo "<td>".$uName."</td>";
		echo "</tr>";
	}
?>
			</table><br>
		<div class="center_title_bar">Users who Bid No Item</div>
			<table class="rwd-table" border="2">
<?php
	include_once 'php_func\statistics.php';
	
	//display users who have not bid for available biddable items
	$result = users_Bid_No_Item(); 
	
	echo "<tr><th>Name of User</th></tr>";
	
	while(list($uName) = pg_fetch_array($result))
	{
		echo "<tr>"; 
		echo "<td>".$uName."</td>";
		echo "</tr>";
	}
?>
			</table><br>
		</div>
		</center>
	</div>
    <!-- end of center content -->
    <div class="right_content">
      
    </div>
    <!-- end of right content -->
  </div>
  <!-- end of main content -->
<?php

	include("includes/admin_footer.php");

?>
<!-- to run drop-down list box function -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
$('#statisticList').on('change', function() {
	if (this.value == 0) {
		document.getElementById('biddingResult').style.display = "block";
		document.getElementById('itemStatistic').style.display = "none";
		document.getElementById('userStatistic').style.display = "none";
	} else 
	if (this.value == 1) {
		document.getElementById('biddingResult').style.display = "none";
		document.getElementById('itemStatistic').style.display = "block";
		document.getElementById('userStatistic').style.display = "none";
	} else
	if (this.value == 2) {
		document.getElementById('biddingResult').style.display = "none";
		document.getElementById('itemStatistic').style.display = "none";
		document.getElementById('userStatistic').style.display = "block";
	}
});
</script>