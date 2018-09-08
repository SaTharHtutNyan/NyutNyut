<?php
	include('Connect.php');
	include('AutoID_Functions.php');
	if (isset($_POST['btnsave']))
	{
		$DFID = $_POST['txtdosID'];
		$DosageFormName = $_POST['txtdosname'];

		$insert = "INSERT INTO dosageform
				   VALUES ('$DFID','$DosageFormName')";
		$ret = mysql_query($insert);
		if ($ret)
		{
			echo "<script>
					window.alert('Successfully SAVED for Dosageform !');
					window.location='DosageForm.php';
				  </script>";
		}
	}
	if (isset($_GET['DID'])) 
	{
		$Action=$_GET['Action'];
		$DID=$_GET['DID'];

		if ($Action=='U') 
		{
			$select="SELECT * FROM dosageform
					 WHERE DFID='$DID'
					";
			$ret=mysql_query($select);
			$data=mysql_fetch_array($ret);
			$DFID=$data['DFID'];
			$DFName=$data['DosageFormName'];
		}//Update Condition
		else if ($Action=='D') 
		{
			$delete="DELETE FROM dosageform
					 WHERE DosageFormID = '$DID'
					";
			$ret=mysql_query($delete);
			if ($ret) 
			{
				echo "<script>
					window.alert('Successfully DELETED !');
					window.location='DosageForm.php';
				  </script>";
			}
		}//Delete Condition
	}
	if (isset($_POST['btnupdate']))
	{
		$DFID = $_POST['txtdosID'];
		$DFName = $_POST['txtdosname'];

		$Update="UPDATE dosageform SET DosageFormName='$DFName' WHERE DosageFormID='$DID'";
		$ret1=mysql_query($Update);
		if ($ret1)
		{
			echo "<script>
					window.alert('Successfully UPDATED !');
					window.location='DosageForm.php';
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
		<table align="center">
			<tr>
				<td><h2> Registeration of DosageForm </h2></td>
			</tr>
			<tr>
				<td>Dosage ID</td>
				<td><input type="text" name="txtdosID" value="<?php 
						if (isset($_GET['DID']))
						{
							echo $DID;
						}
						else
						{
							echo AutoID('DosageForm','DFID','D-',6);
						} ?>" readonly></td>
			</tr>
			<tr>
				<td>DosageForm Name</td>
				<td><input type="text" name="txtdosname" value="<?php if (isset($_GET['DID'])) {echo $DFName;} ?>" required=""></td>
			</tr>
			<tr>
				<td></td>
				<td>
				<?php 
					if (isset($_GET['DID']))
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
	<h1 align="center">DosageForm List</h1>
		<table align="center" width="800px" border="1">
			<tr>
				<th>DosageForm ID</th>
				<th>DosageForm Name</th>
			</tr>
			<?php 
				$select="SELECT * FROM dosageform";
				$ret=mysql_query($select);
				$count=mysql_num_rows($ret);
				for ($i=0; $i <$count ; $i++) 
				{ 
					$data=mysql_fetch_array($ret);
					$DID=$data['DFID'];
					echo"<tr>";
					echo"<td>".$data['DFID']."</td>";
					echo"<td>".$data['DosageFormName']."</td>";
					echo"<td><a href='DosageForm.php?DID=$DID&Action=U'>Update</a>|
							 <a href='DosageForm.php?DID=$DID&Action=D'>Delete</a></td>";
					echo"</tr>";
				}
			?>
		</table>
</body>
</html>