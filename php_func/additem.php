<?php

	include('php_func/functions.php');

	$owner = $_SESSION['login_user'];

	$target_dir = "images/";
	$target_file = $target_dir . $_SESSION["login_user"] . "_" . basename($_FILES["itemPic"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

	if (isset($_POST['formSubmit'])) {

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

			$query = "INSERT INTO item (item_name, description, availability, loansetting, owner, category, item_pic) 
			VALUES (
				'".$_POST['itemName']."',
				'".$_POST['itemDesc']."',
				true,
				'".$_POST['loanSetting']."', 
				'".$owner."', 
				". intval($_POST['itemCat']) .",
				'".$_SESSION["login_user"]."_".basename($_FILES["itemPic"]["name"])."'
				)";

			//echo $query;

			$result = pg_query($query);

			if (!$result) {
				$_SESSION["addItemErrorMsg"] = "Failed to add item.";
			} else {
				$_SESSION["addItemErrorMsg"] = "Success!";
			}

			pg_free_result($result);

		}

	}

	pg_close($dbconn);
?> 