<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres
password=p@ssword")
or die('Could not connect: ' . pg_last_error());

  function first($int, $string){ //function parameters, two variables.
    return $string;  //returns the second argument passed into the function
  }
    
  function select_Available_Items($login_user){
	$query = 'SELECT i.item_name, i.description, c.name, u.name, i.item_pic FROM item i, category c, users u where availability = \'YES\' AND i.category = c.catid AND i.owner = \'' . $email . '\';';
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

	function select_All_Items(){
		$query = 'SELECT * FROM book;';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
	
		return $result;
	}
	
	function select_All_Categories(){
		$query = 'SELECT * FROM category;';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
	
		return $result;
	}
	
	function select_All_Users(){
		$query = 'SELECT * FROM users;';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		
		return $result;
	}
	
	function select_A_User($email){
		$query = 'SELECT * FROM users WHERE email=\'' . $email . '\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		
		return $result;
	}
	
	function admin_insert_New_Item(){
		$cat = $_POST["formItemCategory"];
		echo $cat;
		$name = $_POST["itemname"];
		$desc = $_POST["itemDesc"];
		$shareType = $_POST["shareType"];
		echo $shareType;
		$owner = $_POST["formOwners"];
		echo $owner;
		$query = 'INSERT INTO item (itemID, item_name, description, availability, loanSetting, owner, category) VALUES(
		\'' . str_replace(" ", "_", $name) . $owner . '\', \'' . $name . '\', \'' . $desc . '\', \'YES\', \'' . strtoupper($shareType)
		. '\', \'' . $owner . '\' , \'' . $cat . '\');';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
	
		if(!$result){
			header("Location: ../admin_insert_item.php?message=".urlencode("FAILED"));
		}
		else{
			header("Location: ../admin_insert_item.php?message=".urlencode("SUCCESS"));
		}
	
		return $result;
	}
	
	function admin_insert_New_User(){
		$name = $_POST["username"];
		$email = $_POST["email"];
		$password = $_POST["password"];
		$address = $_POST["address"];
		$query = 'INSERT INTO users (name, email, password, address, logonType) VALUES(
		\'' . $name . '\', \'' . $email . '\', \'' . $password . '\', \'' . $address . '\', \'USERPUBLIC\');';
		$result = pg_query($query);
		
		if(!$result){
			header("Location: ../admin_manage_users.php?message=".urlencode("FAILED"));
		}
		else{
			header("Location: ../admin_manage_users.php?message=".urlencode("SUCCESS"));
		}
		
	}
	
	function admin_update_User_Details($name, $email, $password, $address){
		$query = 'UPDATE users SET name=\''. $name . '\',
		password=\'' . $password . '\', address=\'' . $address . '\' WHERE email=\'' . $email . '\';';
		$result = pg_query($query);
		
		if(!$result){
			header("Location: ../admin_manage_users.php?message=".urlencode("FAILED"));
		}
		else{
			header("Location: ../admin_manage_users.php?message=".urlencode("SUCCESS"));
		}
	}
	
	function admin_Delete_User($email){
		$query = 'DELETE FROM users WHERE email=\'' . $email . '\';';
		$result = pg_query($query);
		
		if(!$result){
			header("Location: ../admin_manage_users.php?message=".urlencode("FAILED"));
		}
		else{
			header("Location: ../admin_manage_users.php?message=".urlencode("SUCCESS"));
		}
	}
	
if(isset($_POST['admin_insert_item_submit']))
{
	admin_insert_New_Item();
}

if(isset($_POST['admin_insert_user_submit']))
{
	admin_insert_New_User();
}
	
//pg_close($dbconn);
?>