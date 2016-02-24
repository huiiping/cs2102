<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres
password=Password1")
or die('Could not connect: ' . pg_last_error());

  function first($int, $string){ //function parameters, two variables.
    return $string;  //returns the second argument passed into the function
  }
    
  function select_Available_Items(){
	$query = 'SELECT i.item_name, i.description, c.name, u.name, i.item_pic FROM item i, category c, users u where availability = \'YES\' AND i.category = c.catid AND i.owner = u.email;';
	$result = pg_query($query) or die('Query failedd: ' . pg_last_error());
	
	return $result;
	}

function select_OnLoan_Items(){
	$query = 'SELECT i.item_name, i.description, c.name, u.name, i.item_pic FROM item i, category c, users u where availability = \'NO\' AND i.category = c.catid AND i.owner = u.email;';
	$result = pg_query($query) or die('Query failedd: ' . pg_last_error());
	
	return $result;
	}
	
	function select_Borrowed_Items(){
	$query = 'SELECT i.item_name, b.bidid, u.name, i.item_pic, borrowedbegin, borrowedend FROM loan l, item i, bid b, users u where l.itemid = i.itemid AND l.bidid = b.bidid AND l.borrower = u.email;';
	$result = pg_query($query) or die('Query failedd: ' . pg_last_error());
	
	return $result;
	}
	
	function select_Current_Bidding_Items(){
	$query = 'SELECT i.item_name, b.bidid, b.bidamt, u.name, i.item_pic, b.datelastbid FROM bid b, item i, users u where b.itemid = i.itemid AND b.bidder = u.email;';
	$result = pg_query($query) or die('Query failedd: ' . pg_last_error());
	
	return $result;
	}

	
//pg_close($dbconn);
?>