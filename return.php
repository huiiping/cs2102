<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres
password=p@ssword")
or die('Could not connect: ' . pg_last_error());

session_start();

$itemID=$_GET['itemID'];
$oldBidPeriod = pg_query("SELECT bidPeriod 
							FROM item_to_bid
							WHERE itemID = '".$itemID."';");
list($getOldBidPeriod)=pg_fetch_array($oldBidPeriod);
							
$oldLoanBegin = pg_query("SELECT loanBegin 
							FROM item_to_bid
							WHERE itemID = '".$itemID."';");	

list($getOldLoanBegin)=pg_fetch_array($oldLoanBegin);
							
$oldLoanPeriod = pg_query("SELECT loanPeriod 
							FROM item_to_bid
							WHERE itemID = '".$itemID."';");
list($getOldLoanPeriod)=pg_fetch_array($oldLoanPeriod);					

$startDate = date_create(date("Y/m/d"));

//$convert_startDate = date("Y/m/d  H:i:s");
$convert_startDate = date_format($startDate, "Y/m/d  H:i:s");
$loadBeginDate = date("Y/m/d  H:i:s", strtotime("+" . $getOldBidPeriod + 5 . " days"));//hard code 5 days after the bidding round is over

$query = "UPDATE item SET availability='TRUE'
			WHERE itemID = '".$itemID."';";
			
$query2 = "UPDATE item_to_bid 
			SET transactionDone = 'TRUE' 
			WHERE itemID = '".$itemID."';";
			
$query3 = "INSERT INTO item_to_bid (itemID, startDate, bidPeriod, loanBegin, loanPeriod, transactionDone) 
			VALUES('".$itemID."', '".$convert_startDate."', '".$getOldBidPeriod."', '". $loadBeginDate ."', '".$getOldLoanPeriod."', 'FALSE');";

		$result = pg_query($query) ;
		$result2 = pg_query($query2);
		$result3 = pg_query($query3)  or die('Query failed: ' . pg_last_error());
		
		if (!$result && !$result2 && !$result3) {
				echo "Not returned.";
		} else {
			echo "Returned!";
		}


header("Location: /mylistings.php#personalitems");
die();

pg_close($dbconn);
?>