<?php

	$page_title = "Manual update Winners";
	
	include("includes/admin_header.php");
	
	if($_SESSION["login_user"]){
		
	}
	else{
		header("location: loginpage.php");
	}
	
?>
	<!-- Insert form here -->
    <div class="center_content">
      <div class="center_title_bar">Updating Winners</div>
		<?php

			include 'php_func\functions.php';
			$getListOfPendingBidRound = select_bid_round_status();
			while (list($itemID, $startDate)=pg_fetch_array($getListOfPendingBidRound)){
				if($itemID != ""){
					check_Winner($itemID, $startDate);
				}
				
			}

			if($_SESSION["bid_Winner"] != ""){
				echo $_SESSION["bid_Winner"];
				$_SESSION["bid_Winner"] = "";
			}
			clearstatcache();
		?>
		
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
