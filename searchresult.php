<?php

	$page_title = "Carou-Share";
	
	include("includes/header.php");
	
?>
    <div class="center_content">
      <div class="center_title_bar">Search Results</div>
	  	
	  <?php
		include 'php_func\functions.php';
		
		$result = search_Results($_GET['newsletter']);
		
		if(pg_num_rows($result) > 0){
			while(list($id,$iName,$iDesc,$iAvail,$iLoanT, $iCat, $iImage, $iOwner)=pg_fetch_array($result)){
				echo '<div class="prod_box">' . '<div class="center_prod_box">' . '<div class="product_title"><a href="#">' . $iName . '</a></div>';
				echo '<div class="product_img"><a href="#"><img src="images/' . $iImage . '" border="0" width="100" height="100" /></a></div>';
				echo '</div></div>';
			}
		}
		else {
			echo 'Sorry, no item found.';
		}
	  ?>
	
    </div>
    <!-- end of center content -->
 <?php

  include("includes/footer.php");

?>