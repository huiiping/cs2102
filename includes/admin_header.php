<!DOCTYPE html>
<?php
	$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=p@ssword")
	or die('Could not connect:' . pg_last_error());
	session_start();
?>
<?php
if($_SESSION["login_user"] && $_SESSION["logon_type"] == "ADMIN") {
		?>
		
		<?php
		}
		else {
			header("location: loginpage.php");
		}
?>
<html>
<head>
<title><?php echo $page_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="style.css" />
<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="iecss.css" />
<![endif]-->
<script type="text/javascript" src="js/boxOver.js"></script>
</head>
<body>
<div id="main_container">
  <div id="header">
    <div class="top_right">
      <div class="languages">
        <div class="lang_text">Languages:</div>
        <a href="#" class="lang"><img src="images/en.gif" alt="" border="0" /></a> <a href="#" class="lang"><img src="images/de.gif" alt="" border="0" /></a> </div>
      <div class="big_banner"> <a href="#"><img src="images/Carou_share-banner.png" alt="" border="0" /></a> </div>
    </div>
    <!-- <div id="logo"> <a href="#"><img src="images/logo.png" alt="" border="0" width="182" height="85" /></a> </div> -->
  </div>
  <div id="main_content">
    <div id="menu_tab">
      <ul class="menu">
        <li><a href="admin_manage_users.php" class="nav"> Home </a></li>
        <li class="divider"></li>
        <li><a href="logout.php" class="nav">Logout</a></li>
        <li class="divider"></li>
      </ul>
    </div>
    <!-- end of menu tab -->
    <div class="crumb_navigation"> Navigation: <span class="current">Home</span>
			<?php
			if($_SESSION["login_user"]) {
				echo '      Signed in as admin' ;
			}
		?>
	</div>
	<div class="left_content">
      <div class="title_box">Categories</div>
      <ul class="left_menu">
        <li class="odd"><a href="admin_manage_users.php">Manage Users</a></li>
        <li class="even"><a href="admin_manage_items.php">Manage Items</a></li>
        <li class="odd"><a href="admin_search_info.php">Search Information</a></li>
		<li class="even"><a href="admin_manual_run_bidding_check.php">Auto Update Bidding Result</a></li>
      </ul>
      

    </div>
    <!-- end of left content -->