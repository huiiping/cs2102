<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres
password=p@ssword")
or die('Could not connect: ' . pg_last_error());

$itemID=$_GET['itemID'];
$owner=$_GET['owner'];
$borrower=$_GET['borrower'];
$rating=$_GET['rating'];

$query = "INSERT INTO rating (itemid, owner, borrower, score) 
			VALUES (
				'".$itemID."',
				'".$owner."',
				'".$borrower."', 
				'".$rating."'
				);";

		$result = pg_query($query);
		
		if (!$result) {
				echo "Rating not added.";
		} else {
			echo "Rating added.";
		}

header("Location: /mylistings.php#borroweditems");
die();

pg_close($dbconn);
?>