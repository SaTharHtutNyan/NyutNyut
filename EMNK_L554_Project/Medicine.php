<?php
	include('Connect.php');
	include('AutoID_Functions.php');
	if (isset($_POST['btnsave']))
	{
		$MID = $_POST['txtMID'];
		$MName = $_POST['txtMedicineName'];
		$Price = $_POST['txtPrice'];
		$DFID = $_POST['cboDFID'];
		$AIID = $_POST['cboAIID'];

		$insert = "INSERT INTO Medicine
				   VALUES ('$MID','$MName','$Price',0,'$DFID','$AIID')";
		$ret = mysql_query($insert);
		if ($ret)
		{
			echo "<script>
					window.alert('Successfully saved for Medicine !');
					window.location='Medicine.php';
				  </script>";
		}
	}
	if (isset($_GET['AIID'])) 
	{
		$Action=$_GET['Action'];
		$AIID=$_GET['AIID'];

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
		$AIID = $_POST['AIID'];
		$AIName = $_POST['txtainame'];

		echo $Update="UPDATE activeingredient SET ActiveIngredientName='$AIName' WHERE AIID='$AIID'";
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
		<input type="hidden" name="AIID" value="<?php echo $AIID; ?>">
		<table align="center">
			<tr>
				<td><h2> Medicine Register </h2></td>
			</tr>
			<tr>
				<td>Medicine ID</td>
				<td><input type="text" name="txtMID" 
					value="<?php
							if (isset($_GET['AIID'])) 
							{
								echo $AIID;
							}
							else
							{
								echo AutoID('Medicine','MedicineID','M-',6);
							} ?>" readonly></td>
			</tr>
			<tr>
				<td>Medicine Name</td>
				<td><input type="text" name="txtMedicineName" value="<?php if (isset($_GET['AIID'])) {echo $AIName;} ?>" 		required=""></td>
			</tr>
			<tr>
				<td>Price</td>
				<td><input type="text" name="txtPrice" value="<?php if (isset($_GET['AIID'])) {echo $AIName;} ?>" 		required=""></td>
			</tr>

			<tr>
				<td>Dosage Form</td>
				<td>
					<select name='cboDFID'>
							<option>Choose Dosage Form</option>
							
								<?php 
									$query1=mysql_query("SELECT * FROM Dosageform");
									$count1=mysql_num_rows($query1);
									for ($i=0; $i < $count1; $i++) { 
										$row1=mysql_fetch_array($query1);
										$DFID=$row1['DFID'];
										$DosageFormName=$row1['DosageFormName'];
										echo "<option value='$DFID'>$DosageFormName</option>";
									}
								 ?>


						</select>
				</td>
			</tr>
			<tr>
				<td>Dosage Form</td>
				<td>
					<select name='cboAIID'>
							<option>Choose Active Ingredient</option>
							
								<?php 
									$query1=mysql_query("SELECT * FROM activeingredient");
									$count1=mysql_num_rows($query1);
									for ($i=0; $i < $count1; $i++) { 
										$row1=mysql_fetch_array($query1);
										$AIID=$row1['AIID'];
										$ActiveIngredientName=$row1['ActiveIngredientName'];
										echo "<option value='$AIID'>$ActiveIngredientName</option>";
									}
								 ?>`


						</select>
				</td>
			</tr>

			<tr>
				<td></td>
				<td>
				<?php 
					if (isset($_GET['AIID']))
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
		<h1 align="center">Medicine List</h1>
		<table align="center" width="800px" border="1">
			<tr>
				<th>Medicine ID</th>
				<th>Medicine Name</th>
				<th>Price</th>
				<th>Quantity</th>
				<th>Dosage Form</th>
				<th>Active Ingredient</th>
				<th>Action</th>
			</tr>
			<?php 
				$select="SELECT * FROM Medicine m, Dosageform d, activeingredient a where m.DFID=d.DFID and m.AIID=a.AIID";
				$ret=mysql_query($select);
				$count=mysql_num_rows($ret);
				for ($i=0; $i <$count ; $i++) 
				{ 
					$data=mysql_fetch_array($ret);
					$MID=$data['MedicineID'];
					echo"<tr>";
					echo"<td>".$data['MedicineID']."</td>";					
					echo"<td>".$data['MedicineName']."</td>";
					echo"<td>".$data['Price']."</td>";
					echo"<td>".$data['Quantity']."</td>";
					echo"<td>".$data['DosageFormName']."</td>";
					echo"<td>".$data['ActiveIngredientName']."</td>";
					echo"<td><a href='Medicine.php?AIID=$AIID&Action=U'>Update</a>|
							 <a href='Medicine.php?AIID=$AIID&Action=D'>Delete</a></td>";
					echo"</tr>";
				}
			?>
		</table>
	</form>
</body>
</html>