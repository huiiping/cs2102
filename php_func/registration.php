<?php
$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres
password=p@ssword")
or die('Could not connect: ' . pg_last_error());

if (isset($_POST['submit'])) { //Execute when user submits form
			  
	if ($_POST['password'] != $_POST['cpassword']) { //Prompt error if password is not matched
		$errormsg = "Password not matched.";
		echo $errormsg;
	
	} else { //Insert data if no errors found
		$name = pg_escape_string($_POST['name']);
		$email = pg_escape_string($_POST['email']);
		$password = pg_escape_string($_POST['password']);
		$address = pg_escape_string($_POST['address']);
		$logon = pg_escape_string($_POST['logon']);
		
		$query = "INSERT INTO users(name, email, password, address, logonType)
				VALUES('$name', '$email', '$password', '$address', '$logon')";
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		
		if (!$result) { //Display error message if insertion fails
			$errormsg = pg_last_error();
			echo $errormsg;
		} else { //Insertion succeeded
			header("Location: /loginpage.php");
		}
	}
	pg_close($dbconn);
}
?>