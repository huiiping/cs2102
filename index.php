<?php

	$page_title = "Carou-Share";
	
	include("includes/header.php");
	
?>
    <div class="center_content">
      <div class="oferta">
        <div class="oferta_details">
          <div class="oferta_title">Welcome to Carou-Share</div>
          <div class="oferta_text"> We would like to share our items to our friends including around the neighbourhood. To do that, we designed this site to cater your needs to put your items in good use.  </div>
          <a href="#" class="prod_buy">details</a> </div>
      </div>
      <div class="center_title_bar">Latest Products</div>
	  
	  
	  
		<?php
		
		include 'php_func\functions.php';
		
		
		$result = select_Available_Bid_Items();
		
		if(pg_num_rows($result) > 0){
				while ($row = pg_fetch_row($result)){
					$getOwner = select_Owner_BasedOn_Item($row[0]);
					list($owner)=pg_fetch_array($getOwner);
					
					if($_SESSION["login_user"] && $owner == $_SESSION["login_user"]){
						continue;
					}
					
					if($owner == ""){
						continue;
					}
					
					$getTimeLeft = select_Item_To_Bid_TimeLeft($row[0], $row[8]);
					list($timeLeft)=pg_fetch_array($getTimeLeft);
					if($timeLeft > 0){
						echo '<div class="prod_box">' . '<div class="product_title"><a href="#">' . '<img src="images/' . $row[5] . '" alt="" border="0" width="180" height="180" />' . '<div align = left>' . nl2br("\n Item: ") . $row[1] . nl2br("\n Description: ") . $row[2] . nl2br("\n Owner: ") . $row[3] . nl2br("\n Pickup Location: ") . $row[6] . nl2br("\n Return Location: ") . $row[7] . nl2br("\n Start Date: ") . date_format(date_create($row[8]), "Y/m/d") .
						"<br><br>" .
						"<td><a href='bid.php?itemID=$row[0]&startDate=$row[8]' class=\"submit_btn\">Bid</a></td>" .
						'</a></div>' . '</div></div>' ;
					}
				}
			}
			else{
				echo 'Sorry, no item found.';
			}
	  ?>

    </div>
    <!-- end of center content -->
<?php

include("includes/footer.php");

?>
