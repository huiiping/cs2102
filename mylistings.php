<?php
	$page_title = "My Listings";
	
	include("includes/header.php");

	if(!isset($_SESSION["login_user"])){
		header("location: loginpage.php");
		exit();
	}
?>

<?php 
		include 'php_func\functions.php';
?>

<html>

	<head>
		<link rel="stylesheet" type="text/css" href="tabstyle.css" />
		<script type="text/javascript" src="js/tabs.js"></script>
		
    </head>

 <body onload="init()">
	<div class="center_content">

		<?php 
		
		extract($_POST); 
			if($upd)
			{
				$itemID=$_POST['itemID'];
				$owner=$_POST['owner'];
				$borrower=$_SESSION['login_user'];
				$rating=$_POST['ratings'];

				
				$query = "SELECT * FROM rating WHERE itemID='" . $itemID . "' AND owner='" . $owner . "' AND borrower='" . $borrower . "';";
				 
				$res = pg_query($query);
				
				if (!$res) {
						echo "Error. Connection problem.";
				} else {
					
					if(pg_num_rows($res) <= 0){
						$query = "INSERT INTO rating (itemid, owner, borrower, score) 
							VALUES (
						'".$itemID."',
						'".$owner."',
						'".$borrower."', 
						'".$rating."'
						);";

						$res = pg_query($query);
						
						if (!$res) {
								echo "Rating not added.";
						} else {
							echo "Rating added.";
						}
					}
					else{
						$query = "UPDATE rating SET score='" . $rating . "' WHERE itemID='" . $itemID . "' AND owner='" . $owner . "' AND borrower='" . $borrower . "';";
						$res = pg_query($query);
						
						if (!$res) {
								echo "Rating not updated.";
						} else {
							echo "Rating updated.";
						}
					}
				}
			}
		?>
		
		<ul id="tabs">
		  <li><a href="#personalitems">Personal Items</a></li>
		  <li><a href="#borroweditems">Borrowed Items</a></li>
		  <li><a href="#biditems">Bid Items</a></li>
		</ul>
		
		<div class="tabContent" id="biditems">
		  <div>
			<p>Showing a list of Bid Items:</p>
			<p>- Current Bids</p>
			<p>- History of Bidding</p>
		  </div>
		  
		   <div class="center_title_bar">Current Bids</div>
		  <?php
			$result = select_Current_Bidding_Items($_SESSION["login_user"]);
			
			if(pg_num_rows($result) > 0){
				while ($row = pg_fetch_row($result)){
					echo '<div class="prod_box">' . '<div class="product_title"><a href="#">' . '<img src="images/' . $row[4] . '" alt="" border="0" width="180" height="180" />' . '<div align = left>' . nl2br("\n Item: ") . $row[0] . nl2br("\n Bid ID: ") . $row[1] . nl2br("\n Bid Amt: ") . $row[2] . nl2br("\n Bidder: ") . $row[3] . nl2br("\n Last Bid Date: ") . $row[5] .
					'</a></div>' . '</div></div>' ;
				}
			}
			else{
				echo '<div class="prod_box">' . '<div class="product_title">' . 'Sorry, no item found.' . '</div></div>' ;
			}
		  ?>
		  
		  <div class="center_title_bar">History of Bidding</div>
		  <?php
			$result = select_Expired_Bidding_Items($_SESSION["login_user"]);
			
			if(pg_num_rows($result) > 0){
				while ($row = pg_fetch_row($result)){
					echo '<div class="prod_box">' . '<div class="product_title"><a href="#">' . '<img src="images/' . $row[4] . '" alt="" border="0" width="180" height="180" />' . '<div align = left>' . nl2br("\n Item: ") . $row[0] . nl2br("\n Bid ID: ") . $row[1] . nl2br("\n Bid Amt: ") . $row[2] . nl2br("\n Bidder: ") . $row[3] . nl2br("\n Last Bid Date: ") . $row[5] .
					'</a></div>' . '</div></div>' ;
				}
			}
			else{
				echo '<div class="prod_box">' . '<div class="product_title">' . 'Sorry, no item found.' . '</div></div>' ;
			}
		  ?>
		  
		</div>
		
		

		<div class="tabContent" id="personalitems">
		  <div>
			<p>Showing a list of Personal Items:</p>
			<p>- Available</p>
			<p>- On Loan</p>
			<p>- History of Loans to Other Users</p>
		  </div>
		  
		  <div class="center_title_bar">Personal Items - AVAILABLE</div>
		
			<?php
			$result = select_Available_Items($_SESSION["login_user"]);
			
			if(pg_num_rows($result) > 0){
				while ($row = pg_fetch_row($result)){
					echo '<div class="prod_box">' . '<div class="product_title"><a href="#">' . '<img src="images/' . $row[4] . '" alt="" border="0" width="180" height="180" />' . '<div align = left>' . nl2br("\n Item: ") . $row[0] . nl2br("\n Description: ") . $row[1] . nl2br("\n Category: ") . $row[2] . nl2br("\n Owner: ") . $row[3] .
					'</a></div>' . '</div></div>' ;
				}
			}
			else{
				echo '<div class="prod_box">' . '<div class="product_title">' . 'Sorry, no item found.' . '</div></div>' ;
			}
			?>
		  
		  <div class="center_title_bar">Personal Items - ON LOAN</div>
			<?php
			$result = select_OnLoan_Items($_SESSION["login_user"]);
			
			if(pg_num_rows($result) > 0){
				while ($row = pg_fetch_row($result)){
					echo '<div class="prod_box">' . '<div class="product_title"><a href="#">' . '<img src="images/' . $row[4] . '" alt="" border="0" width="180" height="180" />' . '<div align = left>' . nl2br("\n Item: ") . $row[0] . nl2br("\n Description: ") . $row[1] . nl2br("\n Category: ") . $row[2] . nl2br("\n Owner: ") . $row[3] .
					"<td><a href='return.php?itemID=$row[5]' class=\"submit_btn\">Return</a></td>" .
					
					'</a></div>' . '</div></div>' ;
					
					
				}
			}
			else{
				echo '<div class="prod_box">' . '<div class="product_title">' . 'Sorry, no item found.' . '</div></div>' ;
			}
			?>
		  
		  <div class="center_title_bar">History of Loans to Other Users</div>
		  <?php
			$result = select_Loan_History($_SESSION["login_user"]);
			
			if(pg_num_rows($result) > 0){
				while ($row = pg_fetch_row($result)){
					echo '<div class="prod_box">' . '<div class="product_title"><a href="#">' . '<img src="images/' . $row[4] . '" alt="" border="0" width="180" height="180" />' . '<div align = left>' . nl2br("\n Item: ") . $row[0] . nl2br("\n Description: ") . $row[1] . nl2br("\n Category: ") . $row[2] . nl2br("\n Borrower: ") . $row[3] .
					
					'</a></div>' . '</div></div>' ;
					
					
				}
			}
			else{
				echo '<div class="prod_box">' . '<div class="product_title">' . 'Sorry, no item found.' . '</div></div>' ;
			}
			?>
		</div>
		
		
		<div class="tabContent" id="borroweditems">
		  <div>
			<p>Showing a list of Borrowed Items:</p>
			<p>- Still Borrowing</p>
			<p>- History of Borrowed Items from Other Users</p>
		  </div>
		  

		 <div class="center_title_bar">Still Borrowing</div>
			<?php
			$result = select_Borrowing_Items($_SESSION["login_user"]);
			
			if(pg_num_rows($result) > 0){
				while ($row = pg_fetch_row($result)){
					echo '<div class="prod_box">' . '<div class="product_title"><a href="#">' . '<img src="images/' . $row[3] . '" alt="" border="0" width="180" height="180" />' . '<div align = left>' . nl2br("\n Item: ") . $row[0] . nl2br("\n Bid ID: ") . $row[1] . nl2br("\n Borrower: ") . $row[2] . nl2br("\n Begin: ") . $row[4] . nl2br("\n End: ") . $row[5] .
					'</a></div>' . '</div></div>' ;
				}
			}
			else{
				echo '<div class="prod_box">' . '<div class="product_title">' . 'Sorry, no item found.' . '</div></div>' ;
			}
		  ?>
		
		<div class="center_title_bar">History of Borrowed Items from Other Users</div>
			<?php
			$result = select_Borrowed_Items($_SESSION["login_user"]);
			
			if(pg_num_rows($result) > 0){
		
				while ($row = pg_fetch_row($result)){
					
					echo '<form method="post" enctype="multipart/form-data">';
					
						echo '<div class="prod_box">' . '<div class="product_title"><a href="#">' . '<img src="images/' . $row[3] . '" alt="" border="0" width="180" height="180" />' . '<div align = left>' . nl2br("\n Item: ") . $row[0] . nl2br("\n Bid ID: ") . $row[1] . nl2br("\n Borrower: ") . $row[2] . nl2br("\n Begin: ") . $row[4] . nl2br("\n End: ") . $row[5] .
					"<br><br>" .
					"<input type = 'Radio' name ='ratings' value= '1'>1" . 
					"<input type = 'Radio' name ='ratings' value= '2'>2" .
					"<input type = 'Radio' name ='ratings' value= '3'>3" .
					"<input type = 'Radio' name ='ratings' value= '4'>4" .
					"<input type = 'Radio' name ='ratings' value= '5'>5" .
					"<input name='itemID' value='" .$row[6]. "' type='hidden' >" .
					"<input name='owner' value='" .$row[7]. "' type='hidden' >" .
					'<input type="submit" value="Rate" name="upd"/></div>' . '</div></div>' ;
					
					echo '</form>';
				}
			}
			else{
				echo '<div class="prod_box">' . '<div class="product_title">' . 'Sorry, no item found.' . '</div></div>' ;
			}
		  ?> 
		</div>
	
	</div>
<!-- end of center content -->


</body>
</html>

<?php
  include("includes/footer.php");
?>