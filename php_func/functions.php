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
		$query = 'SELECT i.item_name, i.description, c.name, u.name, i.item_pic, i.itemID FROM item i, category c, users u where availability = \'NO\' AND i.category = c.catid AND i.owner = u.email AND i.owner = \'' . $email . '\';';
		$result = pg_query($query) or die('Query failedd: ' . pg_last_error());
	
		return $result;
	}
	
	function select_Borrowed_Items($email){
		$query = 'SELECT i.item_name, b.bidid, u.name, i.item_pic, borrowedbegin, borrowedend, i.itemid, i.owner FROM loan l, item i, bid b, users u where l.itemid = i.itemid AND l.bidid = b.bidid AND l.borrower = u.email AND l.borrower = \'' . $email . '\';';
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
	
	function select_Available_Bid_Items(){
		$query = 'SELECT i.itemID, i.item_name, i.description, i.owner, c.name, i.item_pic, i.pickuplocation, i.returnlocation, ib.startdate
		FROM item i, category c, item_to_bid ib 
		WHERE i.category=c.catId AND i.itemID=ib.itemID AND i.availability=\'TRUE\';';

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
		
		$target_dir = "../images/";
		$target_file = $target_dir . $_POST["formOwners"] . "_" . basename($_FILES["imageToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

		// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["imageToUpload"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
		
		// Check if file already exists
		if (file_exists($target_file)) {
			$_SESSION["admin_Insert_Item_Result"] =  "Sorry, this image name already exists. Please rename and upload again.";
			$uploadOk = 0;
		 } 
		
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk != 0) {
			if (move_uploaded_file($_FILES["imageToUpload"]["tmp_name"], $target_file)) {
				//success upload
				//$_SESSION["admin_Insert_Item_Result"] =  "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
			} else {
				$_SESSION["admin_Insert_Item_Result"] =  "Sorry, there was an error uploading your file.";
				$uploadOk = 0;
			}
		}
		
		if($uploadOk != 0){
			$cat = $_POST["formItemCategory"];
			$name = $_POST["itemname"];
			$desc = $_POST["itemDesc"];
			$shareType = $_POST["shareType"];
			$owner = $_POST["formOwners"];
			$query = 'INSERT INTO item (item_name, description, availability, loanSetting, owner, category, item_pic) VALUES(
			\'' . $name . '\', \'' . $desc . '\', \'TRUE\', \'' . strtoupper($shareType)
			. '\', \'' . $owner . '\' , \'' . $cat . '\' , \'' . $owner . "_" . basename($_FILES["imageToUpload"]["name"]) . '\');';
			$result = pg_query($query);
		
			if(!$result){
				$_SESSION["admin_Insert_Item_Result"] = "Failed to add.";
				
			}
			else{
				$_SESSION["admin_Insert_Item_Result"] = "Successfully added.";
			}
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
	
	function select_Current_Total_Bidders($itemId, $startDate){
		$query = 'SELECT COUNT(b.bidID) 
		FROM bid b 
		WHERE b.itemID=\'' . $itemId . '\' AND b.startDate=\'' . $startDate . '\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		
		return $result;
	}
	
	function select_Current_Highest_Bidder($itemId, $startDate){
		$query = 'SELECT MAX(b.bidAmt) 
		FROM bid b 
		WHERE b.itemID=\'' . $itemId . '\' AND b.startDate=\'' . $startDate . '\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		
		return $result;
	}
	
	function select_Current_Bid($itemId, $startDate, $bidder){
		$query = 'SELECT b.bidAmt 
		FROM bid b 
		WHERE b.itemID=\'' . $itemId . '\' AND b.startDate=\'' . $startDate . '\' AND b.bidder=\'' . $bidder . '\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		
		return $result;
	}
	
	//Insert item to bid details
	function insert_item_to_bid($itemId, $startDate, $bidPeriod, $loanBegin, $loanPeriod){
		$convert_startDate = date_create($startDate);
		$convert_endDate = date_create($bidPeriod);
		$convert_loanBegin = date_create($loanBegin);
		$convert_loanReturn = date_create($loanPeriod);
		$query = 'INSERT INTO item_to_bid (itemId, startDate, bidPeriod, loanBegin, loanPeriod) VALUES(
			\'' . $itemId . '\', \'' . date_format($convert_startDate, "Y/m/d  H:i:s") . '\', \'' . $bidPeriod
			. '\', \'' . date_format($convert_loanBegin, "Y/m/d") . '\' , \'' . $loanPeriod . '\');';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		
		if(!$result){
			//$_SESSION["admin_Insert_Item_Result"] = "Failed to add.";
			
		}
		else{
			//$_SESSION["admin_Insert_Item_Result"] = "Successfully added.";
		}
		header("Location: ../index.php");
	}
	
	//select item to bid time left for an item
	function select_Item_To_Bid_TimeLeft($itemId, $startDate){
		$query = 'SELECT bidPeriod FROM item_to_bid 
		WHERE itemID=\'' . $itemId . '\' AND startDate=\'' . $startDate . '\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		list($bidPeriod)=pg_fetch_array($result);
		
		$bidPeriod = "'" . $bidPeriod . ", day'";
		
		$query = 'SELECT ((DATE_PART(\'day\', (startDate + INTERVAL ' . $bidPeriod . ')::timestamp - \'' . date("Y-m-d H:i:s") . '\'::timestamp) * 24 + 
			DATE_PART(\'hour\', (startDate + INTERVAL ' . $bidPeriod . ')::timestamp - \'' . date("Y-m-d H:i:s") . '\'::timestamp)) * 60 + 
			DATE_PART(\'minute\', (startDate + INTERVAL ' . $bidPeriod . ')::timestamp - \'' . date("Y-m-d H:i:s") . '\'::timestamp)) * 60 + 
			DATE_PART(\'second\', (startDate + INTERVAL ' . $bidPeriod . ')::timestamp - \'' . date("Y-m-d H:i:s") . '\'::timestamp)
		FROM item_to_bid 
		WHERE itemID=\'' . $itemId . '\' AND startDate=\'' . $startDate . '\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		
		return $result;
	}
	
	function insert_bid($itemId, $startDate, $bidder, $bidAmt){
		$query = 'SELECT * FROM item_to_bid 
		WHERE itemID=\'' . $itemId . '\' AND startDate=\'' . $startDate . '\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		list($bidPeriod)=pg_fetch_array($result);
	}
	
if(isset($_POST['admin_insert_item_submit']))
{
	admin_insert_New_Item();
}

if(isset($_POST['admin_insert_user_submit']))
{
	admin_insert_New_User();
}

	function search_Results($keyword) {
		$query = 'SELECT i.itemID, i.item_name, i.description, i.availability, i.loanSetting, c.name, i.item_pic, u.name 
		FROM item i, users u, category c 
		WHERE i.category=c.catId AND i.owner=u.email
		AND (LOWER(i.item_name) LIKE LOWER(\'%' . $keyword . '%\') OR LOWER(u.name) LIKE LOWER(\'%' . $keyword . '%\'));';
		
		$result = pg_query($query);
		return $result;
	}

	function match_Password($email, $password) {
		$query = 'SELECT * FROM users where email=\'' . $email . '\' AND password=\'' . $password . '\';';
		
		$result = pg_query($query);
		return $result;
	}
	
	function update_User($name, $email, $password, $address){
		$query = 'UPDATE users SET name=\''. $name . '\', password=\'' . $password . '\', address=\'' . $address .  '\' WHERE email=\'' . $email . '\';';
		
		$result = pg_query($query);
		return $result;
	}
	
//pg_close($dbconn);
?>