<?php

$page_title = "Add Item1";

include("includes/header.php");

if(!isset($_SESSION["login_user"])){
	header("location: loginpage.php");
	exit();
}

?>
<script>
	function showBidSettings() {
		document.getElementById("bidSettings").style.display = "block";
	}

	function hideBidSettings() {
		document.getElementById("bidSettings").style.display = "none";
	}
</script>
<div class="center_content">
	<div class="center_title_bar">Add Item</div>
	<!--Add item form>-->

	<br>
	<form method="post" enctype="multipart/form-data">
		<label>Item Name:</label> <input type="text" name="itemName" id="itemName">
		<br><br>
		<label>Item Picture:</label> <input type="file" name="itemPic" id="itemPic" accept="image/*">
		<br><br>
		<label>Item Description:</label>
		<br>
		<textarea name="itemDesc" id="itemDesc" rows="5"></textarea>
		<br><br>
		<label>Item Category:</label>
		<select name="itemCat" id="itemCat">
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
		<label>Pickup Location:</label> <input type="text" name="pickupLocation">
		<br><br>
		<label>Return Location:</label> <input type="text" name="returnLocation">
		<br><br>
		<input type="radio" name="loanSetting" id="loanSetting_share" value="SHARE" onclick="hideBidSettings()" checked="checked">Share
		<input type="radio" name="loanSetting" id="loanSetting_rent" value="BID" onclick="showBidSettings()">Bid
		<br><br>
		<div id="bidSettings" style="display:none">
			<label>Close bid in </label> 
			<input type="text" size="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="bidPeriodNum">
			<select name="bidPeriodQuantity">
				<option value="1">day(s)</option><br>
				<option value="7">week(s)</option>
			</select>
			<br><br>
		</div>
		<label>Return in </label>
		<input type="text" size="1" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="loanPeriodNum">
		<select name="loanPeriodQuantity">
			<option value="1">day(s)</option><br>
			<option value="7">week(s)</option>
		</select>
		<br><br>
		<input type="submit" name="formSubmit" value="Submit" >
	</form>

	<?php
		include_once('php_func\additem.php');
	?>
	<?php
		if (isset($_POST['formSubmit'])) {
			echo "<br><br>".$_SESSION['addItemErrorMsg']."";
		}
	?>
</div>
<!-- end of center content -->

<?php
	include("includes/footer.php");
?>

