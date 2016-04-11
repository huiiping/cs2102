<?php
$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres
password=p@ssword")
or die('Could not connect: ' . pg_last_error());

	function insert_Bid(){ //new data for bid table
		$query = 'INSERT INTO bid (bidamt, itemid, bidder, datelastbid) VALUES (\'1\', \'4\', \'zen@gmail.com\', NOW()), (\'1\', \'4\', \'danny@dan.com\', NOW());';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
	}
	
	function insert_ItemToBid(){ //insert start date for bid
		$query = 'INSERT INTO item_to_bid (itemID, startDate)
				  VALUES (\'4\', \'2016-03-30 12:00:00+02\'), (\'5\', \'2016-04-02 12:00:00+02\')
				  ;';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
	}
	
	function update_Bid_Toothpaste(){ //update start date
		$query = 'UPDATE bid
				  SET startDate = \'2016-03-30 12:00:00+02\'
				  WHERE itemID = \'4\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
	}
	
	function update_Bid_Scissor(){ //update start date
		$query = 'UPDATE bid
				  SET startDate = \'2016-04-02 12:00:00+02\'
				  WHERE itemID = \'5\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
	}
	
	function update_Bid_Oliver(){ //update bid amount
		$query = 'UPDATE bid 
				  SET bidAmt = \'2\'
				  WHERE itemID = \'4\' 
				  AND bidder = \'oliver@gmail.com\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
	}
	
	function update_Item1(){ //update item
		$query = 'UPDATE item
				  SET pickupLocation = \'Queen Station\', 
				  returnLocation = \'Queen Station\'
				  WHERE itemID = \'4\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
	}
	
	function update_Item2(){ //update item
		$query = 'UPDATE item 
				  SET pickupLocation = \'Marine Lane 2\', 
				  returnLocation = \'Marine Lane 2\'
				  WHERE itemID = \'5\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
	}
	

insert_Bid();
insert_ItemToBid();
update_Bid_Toothpaste();
update_Bid_Scissor();
update_Bid_Oliver();
update_Item1();
update_Item2();
echo "Success";
pg_close($dbconn);
?>