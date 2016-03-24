<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres
password=p@ssword")
or die('Could not connect: ' . pg_last_error());

session_start();

$itemID=$_GET['itemID'];

$query = "UPDATE item SET availability='TRUE'
			WHERE itemID = '".$itemID."';";

		$result = pg_query($query);
		
		if (!$result) {
				echo "Not returned.";
		} else {
			echo "Returned!";
		}

header("Location: /mylistings.php#personalitems");
die();

pg_close($dbconn);
?>