<?php

$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres
password=p@ssword")
or die('Could not connect: ' . pg_last_error());
	
//pg_close($dbconn);


session_start(); // Starting Session


$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
	if (empty($_POST['email']) || empty($_POST['password'])) {
		$error = "Email or Password is invalid";
		echo $error;
	}
	else
	{
		// Define $email and $password
		$email=$_POST['email'];
		$password=$_POST['password'];
		echo $email . '<br>';
		echo $password . '<br>';
		
		$query = 'SELECT * FROM users where email=\''. $email . '\' and password=\'' . $password . '\';';
		$result = pg_query($query);
		
		if (pg_num_rows($result) > 0){
			echo 'success';
			$_SESSION["login_user"]=$email; // Initializing Session
			
			while ($row = pg_fetch_row($result)){
				$_SESSION["login_name"]=$row[0]; // get user's name
				$_SESSION["logon_type"]=$row[5]; // get logontype
			}
		}else {
			header("location: /loginpage.php");
		}
	}
	
	if(isset($_SESSION["login_user"])) {
		if($_SESSION["logon_type"]=="ADMIN") {
			header("location: /admin_manage_users.php");
		}
		else {
			header("location: /index.php");
		}
	}
	
	pg_close($dbconn);
}
?>