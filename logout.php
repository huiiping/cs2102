<?php
session_start();
unset($_SESSION["login_user"]);
unset($_SESSION["logon_type"]);
unset($_SESSION["login_user"]);
header("Location: loginpage.php");
?>