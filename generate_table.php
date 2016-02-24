<?php
$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres
password=p@ssword")
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
			catId SERIAL PRIMARY KEY,
			name VARCHAR(256));';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

/*loanSetting column maybe will be 'share' or 'bid'*/
function create_Item_Table(){
	$query = 'CREATE TABLE item(
			itemID SERIAL PRIMARY KEY,
			item_name VARCHAR(256),
			description VARCHAR(256),
			availability BOOLEAN,
			loanSetting VARCHAR(5) CHECK(loanSetting = \'SHARE\' OR loanSetting=\'BID\'),
			owner VARCHAR(256),
			category INT,
			item_pic VARCHAR(256),
			FOREIGN KEY (owner) REFERENCES users(email) ON DELETE CASCADE,
			FOREIGN KEY (category) REFERENCES category(catId) ON DELETE CASCADE);';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function create_Bid_Table(){
	$query = 'CREATE TABLE bid(
			bidID SERIAL PRIMARY KEY,
			bidAmt float,
			itemID INT,
			bidder VARCHAR(256),
			dateLastBid DATE,
			FOREIGN KEY (itemID) REFERENCES item(itemID) ON DELETE CASCADE,
			FOREIGN KEY (bidder) REFERENCES users(email) ON DELETE CASCADE);';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function create_Loan_Table(){
	$query = 'CREATE TABLE loan(
			itemID INT,
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
	$query = 'INSERT INTO category (name) VALUES (\'Appliances\'), (\'Home Maintenance\'), (\'Personal Care\'), (\'Books\'), (\'Arts and Crafts\');';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function insert_Admin(){
	$query = 'INSERT INTO users (email, password, logonType) VALUES (\'Admin\', \'password\', \'ADMIN\');';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function insert_Users(){
	$query = 'INSERT INTO users (name, email, password, address, display_pic, logonType) VALUES (\'Oliver\', \'oliver@gmail.com\', \'123\', \'Orchard Boulevard\', \'\', \'USERPUBLIC\'),
	(\'Jamie\', \'jamie@gmail.com\', \'123\', \'Bugis Town\', \'\', \'USERPUBLIC\'), (\'Danny\', \'danny@dan.com\', \'123\', \'Chinatown\', \'\', \'USERPUBLIC\'),
	(\'Zen\', \'zen@gmail.com\', \'123\', \'West Coast\', \'\', \'USERPUBLIC\'), (\'Joo\', \'joo@gmail.com\', \'123\', \'East Coast\', \'\', \'USERPUBLIC\');';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function insert_Items(){
	$query = 'INSERT INTO item (item_name, description, availability, loanSetting, owner, category, item_pic) VALUES (\'Hair Dryer\', \'Hair Dryer\', \'TRUE\', \'SHARE\', \'oliver@gmail.com\', \'1\', \'HairDryer.jpg\'), 
	(\'Shaver\', \'Shaver\', \'TRUE\', \'SHARE\', \'oliver@gmail.com\', \'1\', \'Shaver.jpg\'), (\'Bread Toaster\', \'Bread Toaster\', \'FALSE\', \'SHARE\', \'oliver@gmail.com\', \'1\', \'BreadToaster.jpg\'), 
	(\'Toothpaste\', \'Toothpaste\', \'FALSE\', \'BID\', \'danny@dan.com\', \'3\', \'Toothpaste.jpg\'), (\'Scissor\', \'Scissor\', \'FALSE\', \'BID\', \'joo@gmail.com\', \'5\', \'Scissor.jpg\');';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function insert_Bid(){
	$query = 'INSERT INTO bid (bidamt, itemid, bidder, datelastbid) VALUES (\'1\', \'4\', \'oliver@gmail.com\', NOW()), (\'1\', \'5\', \'oliver@gmail.com\', NOW());';
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());
}

function insert_Loan(){
	$query = 'INSERT INTO loan (itemid, bidid, borrower, borrowedbegin, borrowedend) VALUES (\'4\', \'1\', \'oliver@gmail.com\', NOW(), NOW()), (\'5\', \'2\', \'oliver@gmail.com\', NOW(), NOW());';
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
insert_Admin();
insert_Users();
insert_Items();
insert_Bid();
insert_Loan();
echo "Successful Generated all tables";
pg_close($dbconn);
?>