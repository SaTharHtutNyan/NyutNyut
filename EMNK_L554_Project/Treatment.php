<?php
	include('Connect.php');
	include('AutoID_Functions.php');
	if (isset($_POST['btnsave']))
	{
		$TreatmentID = $_POST['txttreatmentID'];
		$TokenNo = $_POST['txtTNO'];
		$Charges = $_POST['txtcharges'];
		$TreatmentDate = $_POST['txttreatmentdate'];
		$NextAppDate = $_POST['txtnextappdate'];

		$insert = "INSERT INTO Treatment
				   VALUES ('$TreatmentID','$TokenNo','$Charges','$TreatmentDate')";
		$ret = mysql_query($insert);
		$update = "UPDATE Appointment SET AppointmentDate='$NextAppDate' WHERE TokenNo='$TokenNo' AND TokenDate='$TreatmentDate'";
		$ret1 = mysql_query($update);

		if ($ret1)
		{
			echo "<script>
					window.alert('Successfully SAVED !');
					window.location='Treatment.php';
				  </script>";
		}
	}
	if(isset($_GET['TNO']))
	{
		$TNO=$_GET['TNO'];
	}
?>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="" method="post">
		<input type="hidden" name="TID" value="<?php echo $TID; ?>">
		<table align="center">
			<tr>
				<td><h2> Treatment </h2></td>
			</tr>
			<tr>
				<td>Treatment ID</td>
				<td><input type="text" name="txttreatmentID" 
					value="<?php 
					if (isset($_GET['TID'])) 
					{
						echo $TreatmentID;
					}
					else
					{
						echo AutoID('Treatment','TreatmentID','T-',6);
					} ?>" readonly></td>
			</tr>
			<tr>
				<td>Token No</td>
				<td><input type="text" name="txtTNO" value="<?php if (isset($_GET['TNO'])) {echo $TNO;} ?>" readonly></td>
			</tr>
			<tr>
				<td>Charges</td>
				<td><input type="text" name="txtcharges" required=""></td>
			</tr>
			<tr>
				<td>Treatment Date</td>
				<td><input type="Date" name="txttreatmentdate" value="<?php echo date('Y-m-d') ?>" readonly></td>
			</tr>
			<tr>
				<td>Next Appointment Date</td>
				<td><input type="Date" name="txtnextappdate" value="<?php echo date('Y-m-d'); ?>"></td>
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
					<input type="submit" name="btnsave" value="Save">
					<input type="reset" name="btncancel" value="Cancel"></td>
			</tr>
		</table>
		<h1 align="center">Treatment List</h1>
		<table align="center" width="800px" border="1">
			<tr>
				<th>Treatment ID</th>
				<th>Token No</th>
				<th>Charges</th>
				<th>Treatment Date</th>
			</tr>
			<?php 
				$select="SELECT * FROM Treatment";
				$ret=mysql_query($select);
				$count=mysql_num_rows($ret);
				for ($i=0; $i <$count ; $i++) 
				{ 
					$data=mysql_fetch_array($ret);
					$TID=$data['TreatmentID'];
					echo"<tr>";
					echo"<td>".$data['TreatmentID']."</td>";					
					echo"<td>".$data['TokenNo']."</td>";
					echo"<td>".$data['Charges']."</td>";					
					echo"<td>".$data['TreatmentDate']."</td>";
					echo"</tr>";
				}
			?>
		</table>
	</form>
</body>
</html>