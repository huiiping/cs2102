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
echo "winner is";
?>