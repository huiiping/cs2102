<?php

	$page_title = "Add Item";
	
	include("includes/header.php");

	if(!isset($_SESSION["login_user"])){
		header("location: loginpage.php");
		exit();
	}
	
?>
    <div class="center_content">
      <div class="center_title_bar">Add Item</div>
	   <!--Add item form>-->

      <form method="post" enctype="multipart/form-data">
				<label>Item Name:</label> <input type="text" name="itemName" id="itemName">
				<br><br>
				<label>Item Picture:</label> <input type="file" name="itemPic" id="itemPic" accept="image/*">
				<br><br>
				<label>Item Description:</label>
				<br>
				<textarea name="itemDesc" id="itemDesc" rows="5"></textarea>
				<br><br>
				<label>Item Category:</label><select name="itemCat" id="itemCat">
  				<?php
  					$query = 'SELECT DISTINCT name, catid FROM category';
  					$result = pg_query($query) or die('Query failed: ' . pg_last_error());
  					while($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
  						$c_id = $row['catid'];
  						echo "<option value=\"".$c_id."\">".$row['name']."</option><br>";
  					}
  					pg_free_result($result);
  				?>
				</select>		
				<br><br>
				<input type="radio" name="loanSetting" id="loanSetting_share" value="SHARE">Share
				<input type="radio" name="loanSetting" id="loanSetting_rent" value="BID">Bid
				<br><br>
				<input type="submit" name="formSubmit" value="Submit" >
         <?php
          include_once('php_func\additem.php');
        ?>
        <?php

          echo "<br><br>".$_SESSION["addItemErrorMsg"]."";

        ?>
			</form>
    </div>
    <!-- end of center content -->

<?php

  include("includes/footer.php");

?>