<?php
$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres
password=cs2102")
or die('Could not connect: ' . pg_last_error());

function create_User_Table(){
	$query = 'CREATE TABLE users(
			name VARCHAR(256),
			email VARCHAR(256) PRIMARY KEY,
			password VARCHAR(256),
			address VARCHAR(256),
			display_pic VARCHAR(256),
			logonType VARCHAR(20) CHECK(logonType = \'ADMIN\' OR logonType=\'USERPUBLIC\'));';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}
function
 create_Category_Table(){
	$query = 'CREATE TABLE category(
			catId INT PRIMARY KEY,
			name VARCHAR(256));';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

/*loanSetting column maybe will be 'share' or 'bid'*/
function create_Item_Table(){
	$query = 'CREATE TABLE item(
			itemID VARCHAR(256) PRIMARY KEY,
			item_name VARCHAR(256),
			description VARCHAR(256),
			availability BOOLEAN,
			loanSetting VARCHAR(5) CHECK(loanSetting = \'SHARE\' OR loanSetting=\'BID\'),
			owner VARCHAR(256),
			category INT,
			FOREIGN KEY (owner) REFERENCES users(email) ON DELETE CASCADE,
			FOREIGN KEY (category) REFERENCES category(catId) ON DELETE CASCADE);';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function create_Bid_Table(){
	$query = 'CREATE TABLE bid(
			bidID INT PRIMARY KEY,
			bidAmt VARCHAR(256),
			itemID VARCHAR(256),
			bidder VARCHAR(256),
			dateLastBid DATE,
			FOREIGN KEY (itemID) REFERENCES item(itemID) ON DELETE CASCADE,
			FOREIGN KEY (bidder) REFERENCES users(email) ON DELETE CASCADE);';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function create_Loan_Table(){
	$query = 'CREATE TABLE loan(
			itemID VARCHAR(256),
			bidID INT,
			borrower VARCHAR(256),
			borrowedBegin DATE,
			borrowedEnd DATE,
			PRIMARY KEY (itemID, bidID, borrower),
			FOREIGN KEY (bidID) REFERENCES bid(bidID) ON DELETE CASCADE,
			FOREIGN KEY (itemID) REFERENCES item(itemID) ON DELETE CASCADE,
			FOREIGN KEY (borrower) REFERENCES users(email) ON DELETE CASCADE);';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function create_Preference_Table(){
	$query = 'CREATE TABLE preference(
			catId INT,
			email VARCHAR(256),
			PRIMARY KEY (catId, email),
			FOREIGN KEY (catId) REFERENCES category(catId) ON DELETE CASCADE,
			FOREIGN KEY (email) REFERENCES users(email) ON DELETE CASCADE);';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function create_Review_Table(){
	$query = 'CREATE TABLE review(
			reviewer VARCHAR(256),
			reviewee VARCHAR(256),
			reviewDate DATE,
			rating INT,
			message VARCHAR(256),
			PRIMARY KEY (reviewer, reviewee, reviewDate),
			FOREIGN KEY (reviewer) REFERENCES users(email) ON DELETE CASCADE,
			FOREIGN KEY (reviewee) REFERENCES users(email) ON DELETE CASCADE);';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function insert_New_Cat(){
	$query = 'INSERT INTO category VALUES (1, \'Book\'), (2, \'Furniture\'), (3, \'Tool\'), (4, \'Appliance\');';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}


create_User_Table();
create_Category_Table();
create_Item_Table();
create_Bid_Table();
create_Loan_Table();
create_Preference_Table();
create_Review_Table();
insert_New_Cat();
echo "Successful Generated all tables";
pg_close($dbconn);
?>