<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres
password=p@ssword")
or die('Could not connect: ' . pg_last_error());

session_start();

$itemID=$_GET['itemID'];				

$query = "UPDATE item SET availability='TRUE'
			WHERE itemID = '".$itemID."';";
			
$query2 = "UPDATE item_to_bid 
			SET transactionDone = 'TRUE' 
			WHERE itemID = '".$itemID."';";
			
$query3 = "DELETE FROM item WHERE itemID='".$itemID."';"
			
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