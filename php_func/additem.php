<?php

	include('php_func/functions.php');

	$owner = $_SESSION['login_user'];

	$target_dir = "images/";
	$target_file = $target_dir . $_SESSION["login_user"] . "_" . basename($_FILES["itemPic"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	if (isset($_POST['formSubmit'])) {

		//Check that image name, etc. isn't null
		if(!isset($_POST['itemName'])) {
			$_SESSION["addItemErrorMsg"] = "Please enter the item name.";
   			break;
		}
		if (!isset($_POST['bidPeriodNum']) && $_POST['loanSetting'] == "BID") {
			$_SESSION["addItemErrorMsg"] = "Please enter a bid length.";
			break;
		}
		if (!isset($_POST['loanPeriodNum'])) {
			$_SESSION["addItemErrorMsg"] = "Please enter a loan length.";
			break;
		}

 		if (isset($_POST['itemPic'])) {

 			// Check if image file is a actual image or fake image
		$check = getimagesize($_FILES["itemPic"]["tmp_name"]);
		if($check) {
			$uploadOk = 1;
		} else {
			$uploadOk = 0;
		}

		// Check if file already exists
		if (file_exists($target_file)) {
			$_SESSION["addItemErrorMsg"] =  "Sorry, this image name already exists. Please rename and upload again.";
			$uploadOk = 0;
		 } 
			
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk != 0) {
			if (move_uploaded_file($_FILES["itemPic"]["tmp_name"], $target_file)) {
			} else {
				$_SESSION["addItemErrorMsg"] =  "Sorry, there was an error uploading your file.";
				$uploadOk = 0;
			}
		}

		if ($uploadOk != 0) {

			$query = "INSERT INTO item (item_name, description, availability, loanSetting, owner, category, item_pic, pickuplocation, returnlocation) 
			VALUES (
				'".$_POST['itemName']."',
				'".$_POST['itemDesc']."',
				TRUE,
				'".$_POST['loanSetting']."', 
				'".$owner."', 
				". intval($_POST['itemCat']) .",
				'".$_SESSION["login_user"]."_".basename($_FILES["itemPic"]["name"])."',
				'".$_POST['pickupLocation']."',
				'".$_POST['returnLocation']."'
				) RETURNING itemID;";

 		}
 	}

 	else { //no image

 		$query = "INSERT INTO item (item_name, description, availability, loanSetting, owner, category, pickuplocation, returnlocation) 
			VALUES (
				'".$_POST['itemName']."',
				'".$_POST['itemDesc']."',
				TRUE,
				'".$_POST['loanSetting']."', 
				'".$owner."', 
				". intval($_POST['itemCat']) .",
				'".$_POST['pickupLocation']."',
				'".$_POST['returnLocation']."'
				) RETURNING itemID;";

 	}
		
 	if ($uploadOk == 0) { //if there was an upload problem, exit
 		break;

 	} else {

		$result = pg_query($query) or die('Query failed: '.pg_last_error());
		
		if (!$result) {

			$_SESSION["addItemErrorMsg"] = "".pg_last_error()."";

		} else {

			$loanDays = intval($_POST['loanPeriodQuantity']) * intval($_POST['loanPeriodNum']);
			$id = pg_fetch_row($result)['0'];

			if ($_POST['loanSetting'] == 'BID') { // if bid
				$bidDays = intval($_POST['bidPeriodQuantity']) * intval($_POST['bidPeriodNum']);
				$query2 = "INSERT INTO item_to_bid (itemid, startdate, bidperiod, loanperiod)
				VALUES (
					'".intval($id)."',
					CURRENT_TIMESTAMP,
					'".intval($bidDays)."',
					'".$loanDays."'
				);";
			}

			else { // if loan
				$query2 = "INSERT INTO item_to_bid (itemid, startdate, bidperiod, loanperiod)
				VALUES (
					'".intval($id)."',
					CURRENT_TIMESTAMP,
					0,
					'".$loanDays."'
				);";
			}
			$result2 = pg_query($query2) or die('Query failed: '.pg_last_error());
			$_SESSION["addItemErrorMsg"] = "Success!";
		}

		pg_free_result($result);

	}

	}

?> 