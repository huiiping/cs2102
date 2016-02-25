<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres
password=p@ssword")
or die('Could not connect: ' . pg_last_error());

  function first($int, $string){ //function parameters, two variables.
    return $string;  //returns the second argument passed into the function
  }
    
  function select_Available_Items($email){
	$query = 'SELECT i.item_name, i.description, c.name, u.name, i.item_pic FROM item i, category c, users u where availability = \'YES\' AND i.category = c.catid AND i.owner = u.email AND i.owner = \'' . $email . '\';';
	$result = pg_query($query) or die('Query failedd: ' . pg_last_error());
	
	return $result;
	}

function select_OnLoan_Items($email){
	$query = 'SELECT i.item_name, i.description, c.name, u.name, i.item_pic FROM item i, category c, users u where availability = \'NO\' AND i.category = c.catid AND i.owner = u.email AND i.owner = \'' . $email . '\';';
	$result = pg_query($query) or die('Query failedd: ' . pg_last_error());
	
	return $result;
	}
	
	function select_Borrowed_Items($email){
	$query = 'SELECT i.item_name, b.bidid, u.name, i.item_pic, borrowedbegin, borrowedend FROM loan l, item i, bid b, users u where l.itemid = i.itemid AND l.bidid = b.bidid AND l.borrower = u.email AND l.borrower = \'' . $email . '\';';
	$result = pg_query($query) or die('Query failedd: ' . pg_last_error());
	
	return $result;
	}
	
	function select_Current_Bidding_Items($email){
	$query = 'SELECT i.item_name, b.bidid, b.bidamt, u.name, i.item_pic, b.datelastbid FROM bid b, item i, users u where b.itemid = i.itemid AND b.bidder = u.email AND b.bidder = \'' . $email . '\';';
	$result = pg_query($query) or die('Query failedd: ' . pg_last_error());
	
	return $result;
	}

	function select_All_Items(){
		$query = 'SELECT i.itemID, i.item_name, i.description, i.availability, i.loanSetting, c.name, i.item_pic, u.name 
		FROM item i, users u, category c 
		WHERE i.category=c.catId AND i.owner=u.email;';
		$result = pg_query($query);
	
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
	
	function select_All_Public_Users(){
		$query = 'SELECT * FROM users WHERE logonType=\'USERPUBLIC\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		
		return $result;
	}
	
	function select_A_Item($itemId){
		$query = 'SELECT i.itemID, i.item_name, i.description, i.availability, i.loansetting, i.category, i.item_pic, i.owner
		FROM item i, users u, category c 
		WHERE i.owner=u.email AND i.category=c.catId AND i.itemID=\'' . $itemId . '\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		
		return $result;
	}
	
	function select_A_User($email){
		$query = 'SELECT * FROM users WHERE email=\'' . $email . '\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		
		return $result;
	}
	
	function admin_insert_New_Item(){
		session_start();
		
		$cat = $_POST["formItemCategory"];
		$name = $_POST["itemname"];
		$desc = $_POST["itemDesc"];
		$shareType = $_POST["shareType"];
		$owner = $_POST["formOwners"];
		$query = 'INSERT INTO item (item_name, description, availability, loanSetting, owner, category) VALUES(
		\'' . $name . '\', \'' . $desc . '\', \'TRUE\', \'' . strtoupper($shareType)
		. '\', \'' . $owner . '\' , \'' . $cat . '\');';
		$result = pg_query($query);
	
		if(!$result){
			$_SESSION["admin_Insert_Item_Result"] = "Failed to add.";
			
		}
		else{
			$_SESSION["admin_Insert_Item_Result"] = "Successfully added.";
		}
	
		header("Location: ../admin_manage_items.php");
	}
	
	function admin_insert_New_User(){
		session_start();
		$find_exist_record = select_A_User($_POST["email"]);
		$err = "";
		if(pg_num_rows($find_exist_record) > 0){
			$err = "This email has been used.";
			$_SESSION["admin_Insert_User_Result"] = $err;
			//echo $err;
		}
		
		$password = $_POST["password"];
		$cpassword = $_POST["confirmpassword"];
		if($password != $cpassword){
			$err = "Password not matched.";
			$_SESSION["admin_Insert_User_Result"] = $err;
			//echo $err;
		}
		
		if($err == ""){
			$name = $_POST["username"];
			$email = $_POST["email"];
			$address = $_POST["address"];
			$query = 'INSERT INTO users (name, email, password, address, logonType) VALUES(
			\'' . $name . '\', \'' . $email . '\', \'' . $password . '\', \'' . $address . '\', \'USERPUBLIC\');';
			$result = pg_query($query);
			
			if(!$result){
				$_SESSION["admin_Insert_User_Result"] = "Failed to register.";
			}
			else{
				$_SESSION["admin_Insert_User_Result"] = "Successfully registered.";
			}
		}
		
		header("Location: ../admin_manage_users.php");
	}
	
	function admin_update_User_Details($name, $email, $password, $address){
		$query = 'UPDATE users SET name=\''. $name . '\',
		password=\'' . $password . '\', address=\'' . $address . '\' WHERE email=\'' . $email . '\';';
		$result = pg_query($query);
		
		if(!$result){
			$_SESSION["admin_Update_User_Result"] = "Failed to update.";
			
		}
		else{
			$_SESSION["admin_Update_User_Result"] = "Successfully Updated.";
		}
	
		header("Location: ../admin_manage_users.php");
	}
	
	function admin_update_Item_Details($itemId, $itemname, $description, $itemCat, $itemShareType, $itemOwner){
		$query = 'UPDATE item SET item_name=\''. $itemname . '\',
		description=\'' . $description . '\', category=\'' . $itemCat . '\', loanSetting=\'' . $itemShareType . '\', owner=\'' . $itemOwner . '\' WHERE itemID=\'' . $itemId . '\';';
		$result = pg_query($query);
		
		if(!$result){
			$_SESSION["admin_Update_Item_Result"] = "Failed to update.";
			
		}
		else{
			$_SESSION["admin_Update_Item_Result"] = "Successfully Updated.";
		}
	
		header("Location: ../admin_manage_items.php");
	}
	
	function admin_Delete_User($email){
		$query = 'DELETE FROM users WHERE email=\'' . $email . '\';';
		$result = pg_query($query);
		
		if(!$result){
			$_SESSION["admin_Delete_User_Result"] = "Failed to delete.";
			
		}
		else{
			$_SESSION["admin_Delete_User_Result"] = "Successfully Deleted.";
		}
	
		header("Location: ../admin_manage_users.php");
	}
	
	function admin_Delete_Item($itemId){
		$query = 'DELETE FROM item WHERE itemID=\'' . $itemId . '\';';
		$result = pg_query($query);
		
		if(!$result){
			$_SESSION["admin_Delete_Item_Result"] = "Failed to delete.";
			
		}
		else{
			$_SESSION["admin_Delete_Item_Result"] = "Successfully Deleted.";
		}
	
		header("Location: ../admin_manage_items.php");
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