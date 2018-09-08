<?php
	include('Connect.php');
	include('TokenFunction.php');
	$today=date('Y-m-d');
	if(isset($_GET['PatientID']))
	{
		$PatientID=$_GET['PatientID'];
	}
	if (isset($_POST['btnsave']))
	{
		$TokenNo = $_POST['txttokno'];
		$PatientID = $_POST['txtpatientid'];
		$today=date('Y-m-d');

		$insert = "INSERT INTO appointment(TokenNo,TokenDate,PatientID)
				   VALUES ('$TokenNo','$today','$PatientID')";
		$ret = mysql_query($insert);
		if ($ret)
		{
			echo "<script>
					window.alert('Successfully SAVED !');
					window.location='Appointment.php';
				  </script>";
		}
	}
	if (isset($_GET['TNO'])) 
	{
		$Action=$_GET['Action'];
		$TokenNo=$_GET['TNO'];

		if ($Action=='D') 
		{
			$delete="DELETE FROM appointment
					 WHERE TokenNo = '$TokenNo'
					";
			$ret=mysql_query($delete);
			if ($ret) 
			{
				echo "<script>
					window.alert('Successfully DELETED !');
					window.location='Appointment.php';
				  </script>";
			}
		}
	}
?>
<?php include('Header.php') ?>
<head>
	<title>Appointment</title>
</head>
	<form action="" method="post">
	<input type="hidden" name="TNO" value="<?php echo $SupplierID; ?>">
		<table align="center">
			<tr>
				<td><h2> Appointment </h2></td>
			</tr>
			<tr>
				<td>Token Number</td>
				<td><input type="text" name="txttokno" 
					value="<?php 
					if (isset($_GET['TNO'])) 
					{
						echo $TokenNo;
					}
					else
					{
						echo AutoID('Appointment','TokenNo','T-',3);
					} ?>" readonly></td>
			</tr>

			<tr>
				<td>Patient ID</td>
				<td><input type="text" name="txtpatientid" value="<?php if(isset($_GET['PatientID'])){echo $_GET['PatientID'];}?>"
					readonly/></td>
			</tr>
			<tr>
				<td></td>
				<td>
				<?php 
					if (isset($_GET['TNO']))
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
	<h1 align="center">Appointment List</h1>
		<table align="center" width="800px" border="1">
			<tr>
				<th>Token No</th>
				<th>Appointment Date</th>
				<th>TokenDate</th>
				<th>Patient ID</th>
			</tr>
			<?php 
				$select="SELECT * FROM appointment";
				$ret=mysql_query($select);
				$count=mysql_num_rows($ret);
				for ($i=0; $i <$count ; $i++) 
				{ 
					$data=mysql_fetch_array($ret);
					$TNO=$data['TokenNo'];
					echo"<tr>";
					echo"<td>".$data['TokenNo']."</td>";
					echo"<td>".$data['AppointmentDate']."</td>";
					echo"<td>".$data['TokenDate']."</td>";
					echo"<td>".$data['PatientID']."</td>";					
					echo"<td><a href='Appointment.php?TNO=$TNO&Action=D'>Delete</a>|
						 	 <a href='TreatmentForm.php?TNO=$TNO&Action=T'>Treatment</a></td>";
					echo"</tr>";
				}
			?>
		</table>
<?php include('Footer.php') ?>