<?php
$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres
password=p@ssword")
or die('Could not connect: ' . pg_last_error());

/*alter bid table*/
function alter_Bid_Table(){
	$query = 'ALTER TABLE bid 
			ADD startDate Timestamp,
			ADD FOREIGN KEY (itemID, startDate) REFERENCES item_to_bid(itemID, startDate) ON DELETE CASCADE;';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}


alter_Bid_Table();
pg_close($dbconn);
?>