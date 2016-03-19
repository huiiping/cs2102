<?php
$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres
password=p@ssword")
or die('Could not connect: ' . pg_last_error());

/*Allow owner to set up the item bidding*/
function create_Item_To_Bid_Table(){
	$query = 'CREATE TABLE item_to_bid(
			itemID INT,
			startDate Timestamp,
			endDate Timestamp ,
			loanBegin Date,
			loanReturn Date,
			PRIMARY KEY (itemID, startDate),
			FOREIGN KEY (itemID) REFERENCES item(itemID) ON DELETE CASCADE);';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

/*alter item table*/
function alter_Item_Table(){
	$query = 'ALTER TABLE item 
			ADD pickupLocation VARCHAR(256),
			ADD returnLocation VARCHAR(256);';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function delete_Review_Tabe(){
	$query = 'DROP TABLE review;';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

/*owner and borrower are emails*/
function create_Rating_Table(){
	$query = 'CREATE TABLE rating(
			itemID INT,
			owner VARCHAR(256),
			borrower VARCHAR(256),
			score INT CHECK(score >= 1 OR score <=5),
			PRIMARY KEY (itemID, owner, borrower),
			FOREIGN KEY (owner) REFERENCES users(email) ON DELETE CASCADE,
			FOREIGN KEY (borrower) REFERENCES users(email) ON DELETE CASCADE,
			FOREIGN KEY (itemID) REFERENCES item(itemID) ON DELETE CASCADE);';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

create_Item_To_Bid_Table();
alter_Item_Table();
delete_Review_Tabe();
create_Rating_Table();
pg_close($dbconn);
?>