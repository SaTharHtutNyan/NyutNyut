<?php
	include('Connect.php');
	include('AutoID_Functions.php');
	if (isset($_POST['btnsave']))
	{
		$TreatmentID = $_POST['txttreatmentID'];
		$MedicineID = $_POST['txtMID'];
		$Quantity = $_POST['txtquantity'];
		$Price = $_POST['txtprice'];

		$insert = "INSERT INTO MedicineUsage
				   VALUES ('$TreatmentID','$MedicineID','$Quantity','$Price')";
		$ret = mysql_query($insert);
		if ($ret)
		{
			echo "<script>
					window.alert('Successfully SAVED !');
					window.location='MedicineUsage.php';
				  </script>";
		}
	}
	if (isset($_GET['TID'])) 
	{
		$Action=$_GET['Action'];
		$TID=$_GET['TreatmentID'];

		if ($Action=='U') 
		{
			$select="SELECT * FROM activeingredient
					 WHERE AIID = '$AIID'
					";
			$ret=mysql_query($select);
			$data=mysql_fetch_array($ret);
			$AIID=$data['AIID'];
			$AIName=$data['ActiveIngredientName'];
		}//Update Condition
		else if ($Action=='D') 
		{
			$delete="DELETE FROM activeingredient
					 WHERE AIID = '$AIID'
					";
			$ret=mysql_query($delete);
			if ($ret) 
			{
				echo "<script>
					window.alert('Successfully DELETED !');
					window.location='ActiveIngredient.php';
				  </script>";
			}
		}//Delete Condition
	}
	if (isset($_POST['btnupdate']))
	{
		$TreatmentID = $_POST['txtTID'];
		$MedicineID = $_POST['txtMID'];
		$Quantity = $_POST['txtquantity'];
		$Price = $_POST['txtprice'];

		echo $Update="UPDATE MedicineUsage SET MedicineID='$MedicineID' WHERE MUID='$MUID'";
		$ret1=mysql_query($Update);
		if ($ret1)
		{
			echo "<script>
					window.alert('Successfully UPDATED !');
					window.location='ActiveIngredient.php';
				  </script>";
		}
	}//Update Method
?>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="" method="post">
		<input type="hidden" name="MUID" value="<?php echo $MUID; ?>">
		<table align="center">
			<tr>
				<td><h2> Medicine Usage </h2></td>
			</tr>
			<tr>
				<td>Treatment ID</td>
				<td><input type="text" name="txtTID" value="<?php if (isset($_GET['MUID'])) {echo $MUID;} ?>" required=""></td>
			</tr>
			<tr>
				<td>Medicine ID</td>
				<td><input type="text" name="txtMID" value="<?php if (isset($_GET['MUID'])) {echo $MUID;} ?>" required=""></td>
			</tr>
			<tr>
			<tr>
				<td>Quantity</td>
				<td><input type="text" name="txtquantity" value="<?php if (isset($_GET['MUID'])) {echo $MUID;} ?>" required=""></td>
			</tr>
			<tr>
				<td>Price</td>
				<td><input type="text" name="txtprice" value="<?php if (isset($_GET['MUID'])) {echo $MUID;} ?>" required=""></td>
			</tr>
			<tr>
				<td></td>
				<td>
				<?php 
					if (isset($_GET['MUID']))
					{
						echo '<input type="submit" name="btnupdate" value="Update">';
					}
					else
					{
						echo '<input type="submit" name="btnsave" value="Save">';
					}
				?>
					<input type="reset" name="btncancel" value="Cancel">
				</td>
			</tr>
		</table>
		<h1 align="center">Medicine Usage List</h1>
		<table align="center" width="800px" border="1">
			<tr>
				<th>Treatment ID</th>
				<th>Medicine ID</th>
				<th>Quantity</th>
				<th>Price</th>
			</tr>
			<?php 
				$select="SELECT * FROM MedicineUsage";
				$ret=mysql_query($select);
				$count=mysql_num_rows($ret);
				for ($i=0; $i <$count ; $i++) 
				{ 
					$data=mysql_fetch_array($ret);
					$MUID=$data['TreatmentID'];
					echo"<tr>";
					echo"<td>".$data['TreatmentID']."</td>";					
					echo"<td>".$data['MedicineID']."</td>";
					echo"<td>".$data['Quantity']."</td>";					
					echo"<td>".$data['Price']."</td>";
					echo"<td><a href='MedicineUsage.php?MUID=$MUID&Action=U'>Update</a>|
							 <a href='MedicineUsage.php?MUID=$MUID&Action=D'>Delete</a></td>";
					echo"</tr>";
				}
			?>
		</table>
	</form>
</body>
</html>