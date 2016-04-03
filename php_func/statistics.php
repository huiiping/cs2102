<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres
password=p@ssword")
or die('Could not connect: ' . pg_last_error());
	
	function insert_Bid(){ //new data for bid table
		$query = 'INSERT INTO bid (bidamt, itemid, bidder, datelastbid) VALUES (\'1\', \'4\', \'zen@gmail.com\', NOW()), (\'1\', \'4\', \'danny@dan.com\', NOW());';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
	}
	
	function bidding_Results() { /*Bidding statistic summary*/
		$query = 'SELECT i.item_name, u.name, b.startDate, b.dateLastBid, b.bidAmt
				  FROM users u, bid b, item i
				  WHERE b.itemID = i.itemID
				  AND b.bidder = u.email
				  ORDER BY i.item_name ASC,b.startDate DESC, b.bidAmt DESC;
				  ';
		$result = pg_query($query);
	
		return $result;
	}
	
	function item_Statistic() { /*Item statistic summary*/
		$query = 'SELECT c.name
				  FROM category c
				  ORDER BY c.name ASC;
				  ';
		$result = pg_query($query);
	
		return $result;
	}
	
	function item_Statistic_All($name) { /*Total no. of items for each category*/
		$query = 'SELECT COUNT(i.itemID)
				FROM category c, item i
				WHERE c.catId = i.category
				AND c.name = \''.$name.'\';
				';
		$result = pg_query($query);
	
		return $result;
	}
	
	function cat_Statistic_Item($name) { /*Name of item from each category*/		
		$query = 'SELECT i.item_name
				  FROM item i, category c
				  WHERE c.catId = i.category
				  AND c.name = \''.$name.'\';
				  ';
		$result = pg_query($query);
	
		return $result;
	}
	
	function cat_Statistic_Bid($name) { /*Total no. of items from each category*/		
		$query = 'SELECT COUNT(*)
				FROM item i, bid b
				WHERE i.itemID = b.itemID
				AND i.item_name = \''.$name.'\'
				';
		$result = pg_query($query);
	
		return $result;
	}	
	
	function loan_Statistic() { /*Loan statistic*/
		$query = 'SELECT i.item_name, c.name, i.loanSetting, 
				  i.pickupLocation, i.returnLocation, u.name
				  FROM loan l, item i, category c, users u
				  WHERE l.itemID = i.itemID
				  AND i.category = c.catId
				  AND l.borrower = u.email;
				  ';
		$result = pg_query($query);
	
		return $result;
	}
	
	function loan_Statistic_Owner($item) { /*Loan statistic, get name of owner*/
		$query = 'SELECT u.name
				  FROM item i, users u
				  WHERE i.owner = u.email
				  AND i.item_name = \''.$item.'\';
				  ';
		$result = pg_query($query);
	
		return $result;
	}
	
	function item_Statistic_Bid() { /*item with more than 1 bid*/
		$query = 'SELECT i.item_name
				  FROM bid b, item i
				  WHERE b.itemID = i.itemID
				  GROUP BY i.item_name
				  HAVING COUNT(*) > 1;
				';
		$result = pg_query($query);
	
		return $result;
	}
	
	function users_Statistic() { /*User statistic summary*/
		$query = 'SELECT u.name
				  FROM users u
				  WHERE u.logonType=\'USERPUBLIC\'
				  ORDER BY u.name ASC
				  ';
		$result = pg_query($query);
	
		return $result;
	}
	
	function users_Statistic_Items($name) { /*Total number of items each user has*/
		$query = 'SELECT COUNT(i.itemID)
				  FROM item i, users u
				  WHERE i.owner = u.email
				  AND u.name = \''.$name.'\';
				  ';
		$result = pg_query($query);
	
		return $result;
	}
	
	function users_Statistic_Loan($name) { /*Total number of loan each user has*/
		$query = 'SELECT COUNT(i.itemID)
				  FROM item i, loan l, users u
				  WHERE i.itemID = l.itemID
				  AND i.owner = u.email
				  AND u.name = \''.$name.'\';
				  ';
		$result = pg_query($query);
	
		return $result;
	}
	
	function users_Statistic_Borrowed($name) { /*Total number of item borrowed for each user*/
		$query = 'SELECT COUNT(DISTINCT l.itemID)
				  FROM loan l, users u
				  WHERE l.borrower = u.email
				  AND u.name = \''.$name.'\';
				  ';
		$result = pg_query($query);
	
		return $result;
	}
	
	function users_Statistic_Bids($name) { /*Total number of bid placed for each user*/
		$query = 'SELECT COUNT(b.bidID)
				  FROM bid b, users u
				  WHERE b.bidder = u.email
				  AND u.name = \''.$name.'\';
				  ';
		$result = pg_query($query);
	
		return $result;
	}
	
	function users_Statistic_Failed($name) { /*Total number of failed bid each user has*/
		$query = 'SELECT COUNT(DISTINCT l.borrower)
				  FROM bid b, users u, loan l
				  WHERE b.bidder = u.email
				  AND u.name = \''.$name.'\'
				  AND b.bidder <> l.borrower;
				  ';
		$result = pg_query($query);
	
		return $result;
	}
	
	function users_Bid_Successful() { /*User bidding statistic*/
		$query = 'SELECT u.name, i.item_name, b.bidAmt
				  FROM bid b, users u, item i, loan l
				  WHERE b.itemID = i.itemID
				  AND b.bidder = u.email
				  AND b.bidID = l.bidID
				  ORDER BY i.item_name ASC;
				  ';
		$result = pg_query($query);
	
		return $result;
	}
	
	function users_Bid_TSuccessful() { /*Total number bid each user has*/
		$query = 'SELECT u.name, COUNT(b.bidID)
				  FROM loan l, bid b, users u
				  WHERE l.bidID = b.bidID
				  AND l.borrower = u.email
				  GROUP BY u.name, u.email;
				  ';
		$result = pg_query($query);
	
		return $result;
	}
	
	function users_Bid_All_Item() { /*Users who bid all biddable items*/
		$query = 'SELECT u.name 
				  FROM bid b, users u
				  WHERE b.bidder = u.email
				  GROUP BY u.name, u.email
				  HAVING COUNT(DISTINCT b.itemID) = (SELECT COUNT(*)
													 FROM item i2
													 WHERE i2.loanSetting=\'BID\');
				  ';
		$result = pg_query($query);
	
		return $result;
	}
	
	function users_Bid_No_Item() { /*Users who have not bid any item*/
		$query = 'SELECT u.name 
				  FROM users u
				  WHERE u.email NOT IN (SELECT b.bidder
										FROM bid b);
				  ';
		$result = pg_query($query);
	
		return $result;
	}
	
//pg_close($dbconn);
?>