<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres
password=p@ssword")
or die('Could not connect: ' . pg_last_error());

session_start();

$itemID=$_GET['itemID'];
$oldBidPeriod = pg_query("SELECT bidPeriod 
							FROM item_to_bid
							WHERE itemID = '".$itemID."';");

							
$oldLoanBegin = pg_query("SELECT loanBegin 
							FROM item_to_bid
							WHERE itemID = '".$itemID."';");	
							
$oldLoanPeriod = pg_query("SELECT loanPeriod 
							FROM item_to_bid
							WHERE itemID = '".$itemID."';");
					

$convert_startDate = date("Y/m/d  H:i:s");

$query = "UPDATE item SET availability='TRUE'
			WHERE itemID = '".$itemID."';";
			
$query2 = "UPDATE item_to_bid 
			SET startdate= '".$convert_startDate."',
			SET transactionDone = 'TRUE',
			WHERE itemID = '".$itemID."';";
			
$query3 = "INSERT INTO item_to_bid (itemId, startDate, bidPeriod, loanBegin, loanPeriod, transactionDone) 
			VALUES(".$itemID."', '".$convert_startDate."', '".$oldBidPeriod."', '".$oldLoanBegin."', '".$oldLoanPeriod."', \'FALSE\');"

		$result = pg_query($query);
		$result2 = pg_query($query2);
		$result3 = pg_query($query3);
		
		if (!$result && !$result2 && !$result3) {
				echo "Not returned.";
		} else {
			echo "Returned!";
		}


header("Location: /mylistings.php#personalitems");
die();

pg_close($dbconn);
?>