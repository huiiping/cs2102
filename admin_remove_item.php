<?php 
	session_start();
	
	if($_SESSION["login_user"] && $_SESSION["logon_type"] == "ADMIN") {
		
	}
	else {
			header("location: loginpage.php");
	}
	
	include 'php_func\functions.php';
	
	admin_Delete_Item($_GET['itemID']);
	
	
 ?>