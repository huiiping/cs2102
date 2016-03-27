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
	  
	  <?php $cat = htmlspecialchars($_GET['category']); ?>
      <div class="center_title_bar">Showing items in <?php echo $cat ?> Category</div>
	  
		<?php
		
		include 'php_func\functions.php';
		
		
		$result = select_Items_By_Category($cat);
		
		if(pg_num_rows($result) > 0){
				while ($row = pg_fetch_row($result)){
					echo '<div class="prod_box">' . '<div class="product_title"><a href="#">' . '<img src="images/' . $row[3] . '" alt="" border="0" width="180" height="180" />' . '<div align = left>' . nl2br("\n Item: ") . $row[0] . nl2br("\n Description: ") . $row[1] . nl2br("\n Owner: ") . $row[2] . nl2br("\n Pickup Location: ") . $row[5] . nl2br("\n Return Location: ") . $row[6] . nl2br("\n Start Date: ") . date_format(date_create($row[7]), "Y/m/d") .
					"<br><br>" .
					"<td><a href='bid.php?itemID=$row[4]&startDate=$row[7]' class=\"submit_btn\">Bid</a></td>" .
					'</a></div>' . '</div></div>' ;
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
