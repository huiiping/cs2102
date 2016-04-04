<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres
password=p@ssword")
or die('Could not connect: ' . pg_last_error());

  function first($int, $string){ //function parameters, two variables.
    return $string;  //returns the second argument passed into the function
  }
    
	function select_Available_Items($email){
		$query = 'SELECT i.item_name, i.description, c.name, u.name, i.item_pic FROM item i, category c, users u where i.availability = \'YES\' AND i.category = c.catid AND i.owner = u.email AND i.owner = \'' . $email . '\';';
		$result = pg_query($query) or die('Query failedd: ' . pg_last_error());
		
		return $result;
	}
	
	function select_Items_By_Category($category){
		$query = 'SELECT i.item_name, i.description, u.name, i.item_pic, i.itemID, i.pickuplocation, i.returnlocation, ib.startdate FROM item i, category c, users u, item_to_bid ib where i.availability = \'YES\' AND i.category = c.catid AND i.owner = u.email AND i.itemID=ib.itemID AND c.name = \'' . $category . '\';';
		$result = pg_query($query) or die('Query failedd: ' . pg_last_error());
		
		return $result;
	}

	function select_OnLoan_Items($email){
		$query = 'SELECT i.item_name, i.description, c.name, u.name, i.item_pic, i.itemID FROM item i, category c, users u where i.availability = \'NO\' AND i.category = c.catid AND i.owner = u.email AND i.owner = \'' . $email . '\';';
		$result = pg_query($query) or die('Query failedd: ' . pg_last_error());
	
		return $result;
	}
	
	function select_Borrowed_Items($email){
		$query = 'SELECT i.item_name, b.bidid, u.name, i.item_pic, borrowedbegin, borrowedend, i.itemid, i.owner FROM loan l, item i, bid b, users u where i.availability = \'NO\' and l.itemid = i.itemid AND l.bidid = b.bidid AND l.borrower = u.email AND l.borrower = \'' . $email . '\';';
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
		WHERE i.category=c.catId AND i.itemID=ib.itemID AND i.availability=\'TRUE\' AND ib.transactionDone=\'FALSE\';';

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
			$pickUp = $_POST["itemPickUp"];
			$returnLoc = $_POST["itemReturnLoc"];
			$query = 'INSERT INTO item (item_name, description, availability, loanSetting, owner, category, item_pic, pickupLocation, returnLocation) VALUES(
			\'' . $name . '\', \'' . $desc . '\', \'TRUE\', \'' . strtoupper($shareType)
			. '\', \'' . $owner . '\' , \'' . $cat . '\' , \'' . $owner . "_" . basename($_FILES["imageToUpload"]["name"]) . '\', \'' . $pickUp . '\', \'' . $returnLoc . '\');';
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
	
	function admin_update_Item_Details($itemId, $itemname, $description, $itemCat, $itemShareType, $itemOwner, $pickUp, $returnLoc){
		$query = 'UPDATE item SET item_name=\''. $itemname . '\',
		description=\'' . $description . '\', category=\'' . $itemCat . '\', loanSetting=\'' . $itemShareType . '\', owner=\'' . $itemOwner . '\', pickupLocation=\'' . $pickUp . '\', returnLocation=\'' . $returnLoc . '\' WHERE itemID=\'' . $itemId . '\';';
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
		$getImagePath = pg_query("SELECT item_pic FROM item WHERE itemID='" . $itemId . "';");
		list($imagePath)=pg_fetch_array($getImagePath);
		$query = 'DELETE FROM item WHERE itemID=\'' . $itemId . '\';';
		$result = pg_query($query);
		
		if(!$result){
			$_SESSION["admin_Delete_Item_Result"] = "Failed to delete.";
			
		}
		else{
			unlink("images/" . $imagePath);//delete the image file
			$_SESSION["admin_Delete_Item_Result"] = "Successfully Deleted." ;
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
		WHERE itemID=\'' . $itemId . '\' AND startDate=\'' . $startDate . '\' AND transactionDone=\'FALSE\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		list($bidPeriod)=pg_fetch_array($result);
		
		$bidPeriod = "'" . $bidPeriod . ", day'";
		
		$query = 'SELECT ((DATE_PART(\'day\', (startDate + INTERVAL ' . $bidPeriod . ')::timestamp - \'' . date("Y-m-d H:i:s") . '\'::timestamp) * 24 + 
			DATE_PART(\'hour\', (startDate + INTERVAL ' . $bidPeriod . ')::timestamp - \'' . date("Y-m-d H:i:s") . '\'::timestamp)) * 60 + 
			DATE_PART(\'minute\', (startDate + INTERVAL ' . $bidPeriod . ')::timestamp - \'' . date("Y-m-d H:i:s") . '\'::timestamp)) * 60 + 
			DATE_PART(\'second\', (startDate + INTERVAL ' . $bidPeriod . ')::timestamp - \'' . date("Y-m-d H:i:s") . '\'::timestamp)
		FROM item_to_bid 
		WHERE itemID=\'' . $itemId . '\' AND startDate=\'' . $startDate . '\' AND transactionDone=\'FALSE\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		
		return $result;
	}
	
	function insert_bid($itemId, $startDate, $bidder, $bidAmt){
		$query = 'SELECT loanSetting FROM item 
		WHERE itemID=\'' . $itemId . '\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		list($loanSetting)=pg_fetch_array($result);
		
		if($loanSetting == "BID"){
			$query = 'SELECT * FROM bid 
			WHERE itemID=\'' . $itemId . '\' AND startDate=\'' . $startDate . '\' AND bidder=\'' . $bidder . '\';';
			$result = pg_query($query) or die('Query failed: ' . pg_last_error());
			if(pg_num_rows($result) > 0){
				$query = 'UPDATE bid SET bidAmt = \'' . $bidAmt . '\' 
				WHERE itemID=\'' . $itemId . '\' AND startDate=\'' . $startDate . '\' AND bidder=\'' . $bidder . '\';';
				$result = pg_query($query) or die('Query failed: ' . pg_last_error());	
				if(!$result){
					$_SESSION["bid_Success"] = "Failed to bid.";
				}
				else{
					$query = 'INSERT INTO bidHistory (bidAmt, itemID, bidder, startDate, dateLastBid, logDate) VALUES(\'' . $bidAmt . '\', \'' . $itemId . '\', \'' . $bidder . '\', \'' . $startDate . '\' , \'' . date("Y-m-d") . '\', NOW());';
					$result = pg_query($query) or die('Query failed: ' . pg_last_error());
					$_SESSION["bid_Success"] = "Bid Successfully.";
				}
			}
			else{
				$query = 'INSERT INTO bid (bidAmt, itemID, bidder, startDate, dateLastBid) VALUES(\'' . $bidAmt . '\', \'' . $itemId . '\', \'' . $bidder . '\', \'' . $startDate . '\' , \'' . date("Y-m-d") . '\');';
				$result = pg_query($query) or die('Query failed: ' . pg_last_error());	
				if(!$result){
					$_SESSION["bid_Success"] = "Failed to bid.";
				}
				else{
					$query = 'INSERT INTO bidHistory (bidAmt, itemID, bidder, startDate, dateLastBid, logDate) VALUES(\'' . $bidAmt . '\', \'' . $itemId . '\', \'' . $bidder . '\', \'' . $startDate . '\' , \'' . date("Y-m-d") . '\', NOW());';
					$result = pg_query($query) or die('Query failed: ' . pg_last_error());
					$_SESSION["bid_Success"] = "Bid Successfully.";
				}
			}
		}
		else{
			$query = 'SELECT * FROM bid 
			WHERE itemID=\'' . $itemId . '\' AND startDate=\'' . $startDate . '\';';
			$result = pg_query($query) or die('Query failed: ' . pg_last_error());
			if(pg_num_rows($result) > 0){
				$_SESSION["bid_Success"] = "You have already placed a bid.";
			}
			else{
				$query = 'INSERT INTO bid (dateLastBid, itemID, bidder, startDate, bidAmt) VALUES(\'' . date("Y-m-d") . '\', \'' . $itemId . '\', \'' . $bidder . '\', \'' . $startDate . '\', \'0\');';
				$result = pg_query($query) or die('Query failed: ' . pg_last_error());	
				if(!$result){
					$_SESSION["bid_Success"] = "Failed to bid.";
				}
				else{
					$query = 'INSERT INTO bidHistory (dateLastBid, itemID, bidder, startDate, bidAmt, logDate) VALUES(\'' . date("Y-m-d") . '\', \'' . $itemId . '\', \'' . $bidder . '\', \'' . $startDate . '\', \'0\', NOW());';
					$result = pg_query($query) or die('Query failed: ' . pg_last_error());
					$_SESSION["bid_Success"] = "Bid Successfully.";
				}
			}
		}
		
		//header("Location: ../bid.php");
	}
	
	//get the bidding status
	function select_bid_round_status(){
	
		$query = 'SELECT itemID, startDate 
		FROM item_to_bid 
		WHERE (startDate::date + bidPeriod) <= \'' . date("Y-m-d H:i:s") . '\' AND loanBegin >= \'' . date("Y-m-d") . '\' AND transactionDone=\'FALSE\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		
		return $result;
	}
	
	function check_Winner($itemId, $startDate){
		$query = 'SELECT loanBegin, (loanBegin::date + loanPeriod) AS loanEnd
		FROM item_to_bid 
		WHERE startDate=\'' . $startDate . '\' AND itemID=\'' . $itemId . '\' AND transactionDone=\'FALSE\';';
		$getItem_To_Bid_Details = pg_query($query) or die('Query failed: ' . pg_last_error());
		list($loanBegin, $loanEnd)=pg_fetch_array($getItem_To_Bid_Details);
		
		$query = 'SELECT loanSetting 
		FROM item   
		WHERE itemID=\'' . $itemId . '\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		
		list($loanSetting)=pg_fetch_array($result);
		
		if($loanSetting == "BID"){
			$query = 'SELECT bidID, bidder 
			FROM bid 
			WHERE itemID=\'' . $itemId . '\' AND startDate=\'' . $startDate . '\' 
			GROUP BY bidID, bidder 
			HAVING bidAmt = (SELECT MAX(bidAmt) FROM bid WHERE itemID=\'' . $itemId . '\' AND startDate=\'' . $startDate . '\');';
			$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		}
		else{
			$query = 'SELECT bidID, bidder 
			FROM bid 
			WHERE itemID=\'' . $itemId . '\' AND startDate=\'' . $startDate . '\' 
			GROUP BY bidID, bidder 	
			HAVING dateLastBid <=ALL (SELECT dateLastBid FROM bid WHERE itemID=\'' . $itemId . '\' AND startDate=\'' . $startDate . '\');';
			$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		}

		$total_rows = pg_num_rows($result);
		$currentIndex = 0;
		$gotRecord_To_Update_bool = true;
		//check if there exists a winner
		while(list($bidID, $bidder)=pg_fetch_array($result)){
			if($currentIndex == $total_rows){
				break;
			}
			$currentIndex++;
			$query = 'SELECT * FROM loan WHERE itemID=\'' . $itemId . '\' AND bidID=\'' . $bidID . '\' AND borrower=\'' . $bidder . '\';';
			$result = pg_query($query) or die('Query failed: ' . pg_last_error());	
			
			if(pg_num_rows($result) <= 0){
				$query = 'INSERT INTO loan (itemID, bidID, borrower, borrowedBegin, borrowedEnd) VALUES(\'' . $itemId . '\', \'' . $bidID . '\', \'' . $bidder . '\', \'' . $loanBegin . '\' , \'' . $loanEnd . '\');';
				$result = pg_query($query) or die('Query failed: ' . pg_last_error());	
				if(!$result){
					$_SESSION["bid_Winner"] = "Error";
				}
				else{
					$query = 'INSERT INTO loanHistory (itemID, bidID, borrower, borrowedBegin, borrowedEnd, logDate) VALUES(\'' . $itemId . '\', \'' . $bidID . '\', \'' . $bidder . '\', \'' . $loanBegin . '\' , \'' . $loanEnd . '\', NOW());';
					$result = pg_query($query) or die('Query failed: ' . pg_last_error());
					
					$query = 'UPDATE item set availability=\'FALSE\' WHERE itemID=\'' . $itemId . '\';';
					$result = pg_query($query) or die('Query failed: ' . pg_last_error());
					
					$_SESSION["bid_Winner"] = "Success";
				}
			}else{
				$gotRecord_To_Update_bool = false;
				
			}
			
		}
		if($total_rows == 0 || !$gotRecord_To_Update_bool){
			$_SESSION["bid_Winner"] = "No record to update";
		}
	}
	
	function select_Owner_BasedOn_Item($itemId){
		$query = 'SELECT u.email
		FROM item i, users u 
		WHERE i.owner=u.email AND i.itemID=\'' . $itemId . '\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		
		return $result;
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
	
	function get_Item_name($itemID){
		$query = 'SELECT item_name FROM item where itemID=\'' . $itemID . '\';';
		
		$result = pg_query($query);
		return $result;
	}
	
	function get_pickup_returnLoc($itemID){
		$query = 'SELECT pickupLocation, returnLocation FROM item where itemID=\'' . $itemID . '\';';
		
		$result = pg_query($query);
		return $result;
	}
//pg_close($dbconn);
?>