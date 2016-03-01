<?php

	$page_title = "Login";
	
	include("includes/header.php");

	if(isset($_SESSION["login_user"])){
		header("location: index.php");
		exit();
	}
	
?>

    <div class="center_content">
      <div class="center_title_bar">Login</div>
	   <!--<form action="php_func\login.php" method="post">-->
	   <form action="php_func\login.php" method="post">
				<label>Email :</label>
				<input id="email" name="email" placeholder="username" type="text">
				<label>Password :</label>
				<input id="password" name="password" placeholder="**********" type="password">
				<input name="submit" type="submit" value=" Login ">
				<span><?php echo $error; ?></span>
		</form>
    </div>

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
