<?php
	include('Connect.php');
	include('AutoID_Functions.php');
	if (isset($_POST['btnsave']))
	{
		$PatientID=AutoID('Patient','PatientID','P-',6);
		$PatientName = $_POST['txtpatname'];
		$Address = $_POST['txtaddress'];
		$Phno = $_POST['txtphno'];
		$Gender = $_POST['txtgender'];
		$DOB = strtotime($_POST['txtdob']);
		$Age = $_POST['txtage'];
		$FatherName = $_POST['txtfatname'];
		$RegDate = $_POST['txtregdate'];
		$LastVisited = $_POST['txtlastvisited'];
		$BloodType = $_POST['txtbloodtype'];
		$PatientID = $_POST['txtpatID'];
		$now=time();
		$diff=$now-$DOB;
		$age=floor($diff/31556926);


		$insert = "INSERT INTO patient
				   VALUES ('$PatientID','$PatientName','$age','$Address','$FatherName','$RegDate','$Phno','$DOB','$Gender','$BloodType')";
		$ret = mysql_query($insert);
		if ($ret)
		{
			echo "<script>
					window.alert('Successfully SAVED for Patient Registration !');
					window.location='Patient.php';
				  </script>";
		}
	}
	if (isset($_GET['PID'])) 
	{
		$Action=$_GET['Action'];
		$PatientID=$_GET['PID'];

		if ($Action=='U') 
		{
			$select="SELECT * FROM patient
					 WHERE PatientID = '$PatientID'
					";
			$ret=mysql_query($select);
			$data=mysql_fetch_array($ret);
			$PatientName=$data['PatientName'];
			$Address=$data['PAddress'];
			$Phno=$data['PPhNo'];
			$Gender=$data['Gender'];
			$DOB=$data['DOB'];
			$Age=$data['Age'];
			$FatherName=$data['FatherName'];
			$RegDate=$data['RegDate'];
			$LastVisited=$data['LastVisited'];
			$BloodType=$data['BloodType'];
			$PatientID=$data['PatientID'];
		}//Update Condition
		else if ($Action=='D') 
		{
			$delete="DELETE FROM patient
					 WHERE PatientID = '$PatientID'
					";
			$ret=mysql_query($delete);
			if ($ret) 
			{
				echo "<script>
					window.alert('Successfully DELETED !');
					window.location='Patient.php';
				  </script>";
			}
		}//Delete Condition
		else if ($Action=='A') 
		{
			$select="SELECT * FROM patient
					 WHERE PatientID = '$PatientID'
					";
			$ret=mysql_query($select);
			if ($ret)
			{
				echo "<script>
					window.location='Appointment.php?PatientID=$PatientID';
					</script>";
			}
		}
	}
	if (isset($_POST['btnupdate']))
	{
		echo $PatientName = $_POST['txtpatname'];
		echo $Age = $_POST['txtpatage'];
		echo $Address = $_POST['txtpataddress'];
		echo $FatherName = $_POST['txtfatname'];
		echo $RegDate = $_POST['txtregdate'];

		$Update="UPDATE patient
				SET PatientName='$PatientName',
				 	Age='$Age',
				 	FatherName='$FatherName',
				 	Address='$Address'
				WHERE PatientID='$PatientID'";
		$ret=mysql_query($Update);
		if ($ret)
		{
			echo "<script>
					window.alert('Successfully UPDATED !');
					window.location='Patient.php';
				  </script>";
		}
	}//Update Method
?>

<html>
<head>
	<title>Patient Registration</title>
	<script type="text/javascript">
		1980-08-10
	function age()
	{
		var dob=document.getElementById('dob').value;
		var year=Number(dob.substr(0,4));
		var month=Number(dob.substr(5,2))-1;
		var day=Number(dob.substr(8,2));
		var today =new Date();
		var age=today.getFullYear()-year;
		if(today.getMonth()<month || (today.getMonth()== month && today.getDate()>day))
		{
			age--;
		}
		
		document.getElementById('CalAge').value=age;
	}

	</script>
</head>
	<form action="" method="post">
	<input type="hidden" name="PID" value="<?php echo $PatientID; ?>">
		<table align="center">
			<tr>
				<td><h2> Patient Registration </h2></td>
			</tr>
			<tr>
				<td>Patient ID</td>
				<td><input type="text" name="txtpatID" 
					value="<?php 
							if (isset($_GET['PID'])) 
							{
								echo $PatientID;
							}
							else
							{
								echo AutoID('Patient','PatientID','P-',6);
							} ?>" readonly></td>
			</tr>
			<tr>
				<td>Patient Name</td>
				<td><input type="text" name="txtpatname" value="<?php if (isset($_GET['PID'])) {echo $PatientName;} ?>" 
					required=""></td>
			</tr>
			<tr>
				<td>Address</td>
				<td><input type="text" name="txtaddress" value="<?php if (isset($_GET['PID'])) {echo $Address;} ?>" 
					required=""></td>
			</tr>
			<tr>
				<td>Phone Number</td>
				<td><input type="text" name="txtphno" value="<?php if (isset($_GET['PID'])) {echo $Phno;} ?>"
					required=""></td>
			</tr>
			<tr>
				<td>Gender</td>
				<td><input type="text" name="txtgender" list="genderlist" value="<?php if (isset($_GET['PID'])) {echo $Gender;} ?>" >
					<datalist id="genderlist">
					    <option value="Male">
					    <option value="Female">
					</datalist>
				</td>	
			</tr>
			<tr>
				<td>Date Of Birth</td>
				<td><input type="date" name="txtdob" id="dob" value="<?php echo date('Y-m-d'); ?>" onChange="age()"></td>
			</tr>
			<tr>
				<td>Age</td>
				<td><input type="text" name="txtage" id="CalAge" value="<?php if (isset($_GET['PID'])) {echo $Phno;} ?>"
					readonly></td>
			</tr>
			<tr>
				<td>Father Name</td>
				<td><input type="text" name="txtfatname" value="<?php if (isset($_GET['PID'])) {echo $FatherName;} ?>"
					required=""></td>
			</tr>
			<tr>
				<td>Registration Date</td>
				<td><input type="date" name="txtregdate" value="<?php echo date('Y-m-d'); ?>" readonly></td>
			</tr>
			<tr>
				<td>Blood Type</td>
				<td><input type="text"  name="txtbloodtype" list="bloodtypelist" value="<?php if (isset($_GET['PID'])) {echo $BloodType;} ?>" >
					<datalist id="bloodtypelist">
					    <option value="A">
					    <option value="B">
					    <option value="O">
					    <option value="AB">
					</datalist>
				</td>	
			</tr>
			<tr>
				<td></td>
				<td>
				<?php 
					if (isset($_GET['PID']))
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
		<h1 align="center">Patient List</h1>
		<table align="center" border="1">
			<tr>
				<th>Patient ID</th>
				<th>Patient Name</th>
				<th>Address</th>
				<th>Phone Number 1</th>
				<th>Gender</th>
				<th>Date Of Birth</th>
				<th>Age</th>
				<th>Father Name</th>
				<th>Register Date</th>
				<th>Blood Type</th>
				<th>Action</th>
			</tr>
			<?php 
				$select="SELECT * FROM patient";
				$ret=mysql_query($select);
				$count=mysql_num_rows($ret);
				for ($i=0; $i <$count ; $i++) 
				{ 
					$data=mysql_fetch_array($ret);
					$PID=$data['PatientID'];
					echo"<tr>";
					echo"<td>".$data['PatientID']."</td>";
					echo"<td>".$data['PatientName']."</td>";
					echo"<td>".$data['Address']."</td>";
					echo"<td>".$data['PhoneNumber']."</td>";
					echo"<td>".$data['Gender']."</td>";
					echo"<td>".$data['DOB']."</td>";
					echo"<td>".$data['Age']."</td>";
					echo"<td>".$data['FatherName']."</td>";
					echo"<td>".$data['RegDate']."</td>";
					echo"<td>".$data['BloodType']."</td>";

					echo"<td><a href='Patient.php?PID=$PID&Action=U'>Update</a>|
							 <a href='Patient.php?PID=$PID&Action=D'>Delete</a>|
							 <a href='Patient.php?PID=$PID&Action=A'>Appointment</a></td>";
					echo"</tr>";
				}
			?>
		</table>
	</form>
</html>