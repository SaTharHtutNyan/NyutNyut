<?php
	include('Connect.php');
	include('AutoID_Functions.php');
	if (isset($_POST['btnsave']))
	{
		$StaffID = $_POST['txtstID'];
		$StaffName = $_POST['txtstname'];
		$StaffAge = $_POST['txtstage'];
		$StaffPhoneNo = $_POST['txtstphno'];
		$Salary = $_POST['txtstsalary'];
		$Email = $_POST['txtemail'];
		$Password = $_POST['txtpassword'];
		$RegDate = $_POST['txtregdate'];

		$insert = "INSERT INTO staff
				   VALUES ('$StaffID','$StaffName','$StaffAge','$StaffPhoneNo','$Salary','$Email','$Password','$RegDate')";
		$ret = mysql_query($insert);
		if ($ret)
		{			
			echo"<script> 
				 window.alert('Staff's information are Successfully SAVED !');
			     window.location='Staff.php';
			     </script>";
		}
	}
	if (isset($_GET['STID'])) 
	{
		$Action=$_GET['Action'];
		$StaffID=$_GET['STID'];

		if ($Action=='U') 
		{
			$select="SELECT * FROM staff
					 WHERE StaffID = '$StaffID'
					";
			$ret=mysql_query($select);
			$data=mysql_fetch_array($ret);
			$StaffName=$data['StaffName'];
			$StaffAge=$data['StaffAge'];
			$StaffPhoneNo=$data['StaffPhoneNo'];
			$Salary=$data['Salary'];
			$Email=$data['Email'];
			$Password=$data['Password'];
			$RegDate=$data['RegDate'];
		}//Update Condition
		else if ($Action=='D') 
		{
			$delete="DELETE FROM staff
					 WHERE StaffID = '$StaffID'
					";
			$ret=mysql_query($delete);
			if ($ret) 
			{
				echo "<script>
					window.alert('Successfully DELETED !');
					window.location='Staff.php';
				  </script>";
			}
		}//Delete Condition
	}
	if (isset($_POST['btnupdate']))
	{
		echo $StaffID = $_POST['STID'];
		echo $StaffName = $_POST['txtstname'];
		echo $StaffAge = $_POST['txtstage'];
		echo $StaffPhoneNo = $_POST['txtstphno'];
		echo $Salary = $_POST['txtstsalary'];
		echo $Email = $_POST['txtemail'];
		echo $Password = $_POST['txtpassword'];
		echo $RegDate = $_POST['txtregdate'];

		$Update="UPDATE staff
				 SET StaffName='$StaffName',
				 	 StaffAge='$StaffAge',
				 	 StaffPhoneNo='$StaffPhoneNo',
				 	 Salary='$Salary',
				 	 Email='$Email',
				 	 Password='$Password'
				 WHERE StaffID='$StaffID'";
		$ret=mysql_query($Update);
		if ($ret)
		{
			echo "<script>
					window.alert('Successfully UPDATED !');
					window.location='Staff.php';
				  </script>";
		}
	}//Update Method	
?>

<?php include('Header.php') ?>
<head>
	<title>Staff Registration</title>
</head>
	<form action="" method="post">
		<input type="hidden" name="STID" value="<?php echo $StaffID; ?>">
		<table align="center">
			<tr>
				<td><h2> Staff Registration </h2></td>
			</tr>
			<tr>
				<td>Staff ID</td>
				<td><input type="text" name="txtstID" 
					value="<?php 
							if (isset($_GET['STID'])) 
							{
								echo $StaffID;
							} 
							else 
							{
								echo AutoID('Staff','StaffID','St-',6);
							} ?>" readonly></td>
			</tr>
			<tr>
				<td>Staff Name</td>
				<td><input type="text" name="txtstname" value="<?php if (isset($_GET['STID'])) {echo $StaffName;} ?>" 
					required=""></td>
			</tr>
			<tr>
				<td>Age</td>
				<td><input type="text" name="txtstage" value="<?php if (isset($_GET['STID'])) {echo $StaffAge;} ?>" 
					required=""></td>
			</tr>
			<tr>
				<td>Phone Number</td>
				<td><input type="text" name="txtstphno" value="<?php if (isset($_GET['STID'])) {echo $StaffPhoneNo;} ?>" 
					required=""></td>
			</tr>
			<tr>
				<td>Slary</td>
				<td><input type="text" name="txtstsalary" value="<?php if (isset($_GET['STID'])) {echo $Salary;} ?>" 
					required=""></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input type="text" name="txtemail" value="<?php if (isset($_GET['STID'])) {echo $Email;} ?>" 
					required=""></td>
			</tr>
			<tr>
				<td>Password</td>
				<td><input type="password" name="txtpassword" value="<?php if (isset($_GET['STID'])) {echo $Password;} ?>" 
					required="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{4,8}" 
				    title="Enter at least one number, one lowercase and uppercase between 4 to 8"></td>	
			</tr>
			<tr>
				<td>Registration Date</td>
				<td><input type="text" name="txtregdate" value="<?php echo date('Y-m-d'); ?>" readonly></td>
			</tr>
			<tr>
				<td></td>
				<td>
				<?php 
					if (isset($_GET['STID']))
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
	</form>
		<h1 align="center">Staff List</h1>
		<table align="center" width="800px" border="1">
			<tr>
				<th>Staff Name</th>
				<th>Age</th>
				<th>Staff Phone Number</th>
				<th>Salary</th>
				<th>Email</th>
				<th>Password</th>
				<th>Registration Date</th>
			</tr>
			<?php 
				$select="SELECT * FROM staff";
				$ret=mysql_query($select);
				$count=mysql_num_rows($ret);
				for ($i=0; $i <$count ; $i++) 
				{ 
					$data=mysql_fetch_array($ret);
					$STID=$data['StaffID'];
					echo"<tr>";
					echo"<td>".$data['StaffName']."</td>";
					echo"<td>".$data['StaffAge']."</td>";
					echo"<td>".$data['StaffPhoneNo']."</td>";
					echo"<td>".$data['Salary']."</td>";
					echo"<td>".$data['Email']."</td>";
					echo"<td>".$data['Password']."</td>";
					echo"<td>".$data['RegDate']."</td>";
					echo"<td><a href='Staff.php?STID=$STID&Action=U'>Update</a>|
							 <a href='Staff.php?STID=$STID&Action=D'>Delete</a></td>";
					echo"</tr>";
				}
			?>
		</table>
<?php include('Footer.php') ?>