<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Manage Users</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<link rel="stylesheet" type="text/css" href="style.css" />
<!--[if IE 6]>
<link rel="stylesheet" type="text/css" href="iecss.css" />
<![endif]-->
<script type="text/javascript" src="js/boxOver.js"></script>
<?php 
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
</head>
<body>
<div id="main_container">
  <div id="header">
    <div class="top_right">
      <div class="big_banner"> <a href="#"><img src="images/banner728.jpg" alt="" border="0" /></a> </div>
    </div>
    <div id="logo"> <a href="#"><img src="images/logo.png" alt="" border="0" width="182" height="85" /></a> </div>
  </div>
  <div id="main_content">
    <div id="menu_tab">
      <ul class="menu">
        <li><a href="#" class="nav"> Home </a></li>
        <li class="divider"></li>
        <li><a href="logout.php" class="nav">Logout</a></li>
        <li class="divider"></li>
      </ul>
    </div>
    <!-- end of menu tab -->
    <div class="crumb_navigation"> Navigation: <span class="current">Manage Users</span> </div>
    <div class="left_content">
      <div class="title_box">Menu</div>
      <ul class="left_menu">
        <li class="odd"><a href="admin_manage_users.php">Manage Users</a></li>
        <li class="odd"><a href="admin_manage_items.php">Manage Items</a></li>
        <li class="even"><a href="admin_search_info.php">Search Information</a></li>
      </ul>
      <div class="border_box">
      </div>
    </div>
    <!-- end of left content -->
	<!-- Insert form here -->
    <div class="center_content">
      <div class="center_title_bar">Manage Users</div>
	  <div><span id="time"></span></div>
	  <div><span id="itemTime"></span></div>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	   <script>
		
		function startTimer(duration, display) {
			var timer = duration, minutes, seconds;
			setInterval(function () {
				day = parseInt((((timer / 60) / 60) / 24) % 24, 10)
				hr = parseInt(((timer / 60) / 60) % 24, 10);
				minutes = parseInt((timer / 60) % 60, 10);
				seconds = parseInt(timer % 60, 10);

				day = day < 10 ? "0" + day : day;
				hr = hr < 10 ? "0" + hr : hr;
				minutes = minutes < 10 ? "0" + minutes : minutes;
				seconds = seconds < 10 ? "0" + seconds : seconds;
				
				$.ajax({
                type: "GET",
                url: "load_bid_status.php",
                success : function(data) { 
					
                    // here is the code that will run on client side after running clear.php on server
					displayItem = document.querySelector('#itemTime');
					displayItem.style.fontSize = "30px";
                    // function below reloads current page
					displayItem.textContent = data;
                    //location.reload();
					
                }
				});


				display.textContent = " Bidding will close in: " + day + " Days " +  hr + ":" + minutes + ":" + seconds;

				if (--timer < 0) {
					timer = 0;
				}


			}, 1000);
		}

		window.onload = function () {
			var fiveMinutes = 300000,
				display = document.querySelector('#time');
				display.style.fontSize = "30px";
			startTimer(fiveMinutes, display);
		};
		</script>
		
    </div>
    <!-- end of center content -->
    <div class="right_content">
      
    </div>
    <!-- end of right content -->
  </div>
  <!-- end of main content -->
  <div class="footer">
    <div class="left_footer"> <img src="images/footer_logo.png" alt="" width="89" height="42"/> </div>
    <div class="center_footer"> Template name. All Rights Reserved 2008<br />
      <a href="http://csscreme.com"><img src="images/csscreme.jpg" alt="csscreme" title="csscreme" border="0" /></a><br />
      <img src="images/payment.gif" alt="" /> </div>
    <div class="right_footer"> <a href="#">home</a> <a href="#">about</a> <a href="#">sitemap</a> <a href="#">rss</a> <a href="#">contact us</a> </div>
  </div>
</div>
<!-- end of main_container -->
</body>
</html>
