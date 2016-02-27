<?php

	$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=p@ssword")
	or die('Could not connect:' . pg_last_error());

	include('php_func/functions.php');

	$owner = $_SESSION['login_user'];

	if (isset($_POST['formSubmit'])) {

		$query = "INSERT INTO item (item_name, description, availability, loansetting, owner, category) 
		VALUES (
			'".$_POST['itemName']."',
			'".$_POST['itemDesc']."',
			true,
			'".$_POST['loanSetting']."', 
			'".$owner."', 
			". intval($_POST['itemCat']) ."
			)";

		//echo $query;

		$result = pg_query($query) or die('Query failed: ' . pg_last_error());

		pg_free_result($result);

	}

	pg_close($dbconn);
?> 