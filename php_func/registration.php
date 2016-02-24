<?php
$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres
password=p@ssword")
or die('Could not connect: ' . pg_last_error());

session_start(); // Starting Session

if (isset($_POST['submit'])) { //Execute when user submits form
	
	$errormsg = "";
	
	if (isset($_POST['email'])) { //Prompt error if email is duplicated
		$query = 'SELECT * FROM users where email=\''. $_POST['email'] . '\';';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		
		if (pg_num_rows($result) > 0) {
			$errormsg = "Invalid email,	";
			echo $errormsg;
		}
	} 
	
	if ($_POST['password'] != $_POST['cpassword']) { //Prompt error if password is not matched
		$errormsg = "	Password not matched.";
		echo $errormsg;
	} 
	
	if ($errormsg == "") {
		$name = pg_escape_string($_POST['name']);
		$email = pg_escape_string($_POST['email']);
		$password = pg_escape_string($_POST['password']);
		$address = pg_escape_string($_POST['address']);
		
		$query = "INSERT INTO users(name, email, password, address, logonType)
					VALUES('$name', '$email', '$password', '$address', 'USERPUBLIC');";
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		
		if (!$result) { //Display error message if insertion fails
			$errormsg = pg_last_error();
			echo $errormsg;
			
		} else { //Insertion succeeded and login user
			//Copied from login.php
			$query = 'SELECT * FROM users where email=\''. $email . '\';';
			$result = pg_query($query);
			
			if (pg_num_rows($result) > 0){
				echo 'success';
				$_SESSION["login_user"]=$email; // Initializing Session
				
				while ($row = pg_fetch_row($result)){
					$_SESSION["login_name"]=$row[0]; // get user's name
					$_SESSION["logon_type"]=$row[5]; // get logontype
				}
			}
			if(isset($_SESSION["login_user"])) {
				header("location: /index.php");
			}
		}
	}
	pg_close($dbconn);
}
?>