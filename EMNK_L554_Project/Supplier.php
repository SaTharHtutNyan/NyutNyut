<?php
	include('Connect.php');
	if (isset($_POST['btnsave']))
	{
		$SupName = $_POST['txtsupname'];
		$SupAddress = $_POST['txtsupaddress'];
		$SupPhoneno = $_POST['txtsupphoneno'];

		$insert = "INSERT INTO supplier(SupplierName,Address,PhoneNo)
				   VALUES ('$SupName','$SupAddress','$SupPhoneno')";
		$ret = mysql_query($insert);
		if ($ret)
		{
			echo "<script>
					window.alert('Successfully SAVED !');
					window.location='Supplier.php';
				  </script>";
		}
	}
	if (isset($_GET['SID'])) 
	{
		$Action=$_GET['Action'];
		$SupplierID=$_GET['SID'];

		if ($Action=='U') 
		{
			$select="SELECT * FROM supplier
					 WHERE SupplierID = '$SupplierID'
					";
			$ret=mysql_query($select);
			$data=mysql_fetch_array($ret);
			$SupplierName=$data['SupplierName'];
			$Address=$data['Address'];
			$PhoneNo=$data['PhoneNo'];
		}//Update Condition
		else if ($Action=='D') 
		{
			$delete="DELETE FROM supplier
					 WHERE SupplierID = '$SupplierID'
					";
			$ret=mysql_query($delete);
			if ($ret) 
			{
				echo "<script>
					window.alert('Successfully DELETED !');
					window.location='Supplier.php';
				  </script>";
			}
		}//Delete Condition
	}
	if (isset($_POST['btnupdate']))
	{
		echo $SupplierID = $_POST['SID'];
		echo $SupplierName = $_POST['txtsupname'];
		echo $Address = $_POST['txtsupaddress'];
		echo $PhoneNo = $_POST['txtsupphoneno'];

		$Update="UPDATE supplier
				SET SupplierName='$SupplierName',Address='$Address',PhoneNo='$PhoneNo'
				WHERE SupplierID='$SupplierID'";
		$ret=mysql_query($Update);
		if ($ret)
		{
			echo "<script>
					window.alert('Successfully UPDATED !');
					window.location='Supplier.php';
				  </script>";
		}
	}//Update Method
?>
<?php include('Header.php') ?>
<head>
	<title>Supplier</title>
</head>
	<form action="" method="post">
	<input type="hidden" name="SID" value="<?php echo $SupplierID; ?>">
		<table align="center">
			<tr>
				<td><h2> Supplier Registration </h2></td>
			</tr>
			<tr>
				<td>Supplier Name</td>
				<td><input type="text" name="txtsupname" value="<?php if (isset($_GET['SID'])) {echo $SupplierName;} ?>" 
					required/></td>
			</tr>
			<tr>
				<td>Address</td>
				<td><input type="text" name="txtsupaddress" value="<?php if (isset($_GET['SID'])) {echo $Address;} ?>" 
					required/></td>
			</tr>
			<tr>
				<td>Phone Number</td>
				<td><input type="text" name="txtsupphoneno" value="<?php if (isset($_GET['SID'])) {echo $PhoneNo;} ?>"
					required/></td>
			</tr>
			<tr>
				<td></td>
				<td>
				<?php 
					if (isset($_GET['SID']))
					{
						echo '<input type="submit" name="btnupdate" value="Update">';
					}
					else
					{
						echo '<input type="submit" name="btnsave" value="Save">';
					}//Button Changes
				 ?>
				<input type="reset" name="btncancel" value="Cancel"></td>
			</tr>
		</table>
	</form>
	<h1 align="center">Supplier List</h1>
		<table align="center" width="800px" border="1">
			<tr>
				<th>Supplier Name</th>
				<th>Address</th>
				<th>PhoneNumber</th>
				<th>Process</th>
			</tr>
			<?php 
				$select="SELECT * FROM supplier";
				$ret=mysql_query($select);
				$count=mysql_num_rows($ret);
				for ($i=0; $i <$count ; $i++) 
				{ 
					$data=mysql_fetch_array($ret);
					$SID=$data['SupplierID'];
					echo"<tr>";
					echo"<td>".$data['SupplierName']."</td>";
					echo"<td>".$data['Address']."</td>";
					echo"<td>".$data['PhoneNo']."</td>";
					echo"<td><a href='Supplier.php?SID=$SID&Action=U'>Update</a>|
							 <a href='Supplier.php?SID=$SID&Action=D'>Delete</a></td>";
					echo"</tr>";
				}
			?>
		</table>
<?php include('Footer.php') ?>