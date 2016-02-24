<html>
<head> <title>Add Item</title> </head>
<body>
	<a href="index.php">Index</a>
	<table>
		<tr> <td colspan="2" style="background‐color:#FFA500;">
			<h1>Add Item</h1>
		</td> </tr>

		<?php
			$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=p@ssword")
			or die('Could not connect:' . pg_last_error());
		?>

		<tr>
			<td style="background‐color:#eeeeee;">
				<form>
					Item Name: <input type="text" name="itemName" id="itemName">
					<br><br>
					Item Picture: <input type="file" name="itemPic" id="itemPic">
					<br><br>
					Item Description:
					<br>
					<textarea name="itemDesc" id="itemDesc" rows="5"></textarea>
					<br><br>
					<select name="itemCat" id="itemCat"> <option value="">Item Category</option> 
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
				</form>

				<?php
					include('login.php');
					include('php_func/functions.php');

					$owner=$_SESSION['login_user'];



					if (isset($_GET['formSubmit'])) {


						$query = "INSERT INTO item (itemID, item_name, description, availability, loansetting, owner, category) 
						VALUES ( (SELECT COUNT(*) FROM item),
							'".$_GET['itemName']."',
							'".$_GET['itemDesc']."',
							true,
							'".$_GET['loanSetting']."', 
							'".$owner."', 
							". intval($_GET['itemCat']) .")";

						$result = pg_query($query) or die('Query failed: ' . pg_last_error());
						pg_free_result($result);

					}

				?>

			</td>
		</tr>
		<?php
			pg_close($dbconn);
		?>
	</table>
</body>
</html>

