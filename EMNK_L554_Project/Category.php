<?php
	include('Connect.php');
	include('AutoID_Functions.php');
	if (isset($_POST['btnsave']))
	{
		$CategoryID = $_POST['txtcatID'];
		$CategoryName = $_POST['txtcatname'];

		$insert = "INSERT INTO category
				   VALUES ('$CategoryID','$CategoryName')";
		$ret = mysql_query($insert);
		if ($ret)
		{
			echo "<script>
					window.alert('Registration of Category is SUCCESSFULLY DONE !');
					window.location='Category.php';
				  </script>";
		}
	}
	if (isset($_GET['CID'])) 
	{
		$Action=$_GET['Action'];
		$CategoryID=$_GET['CID'];

		if ($Action=='U') 
		{
			$select="SELECT * FROM category
					 WHERE CategoryID = '$CategoryID'
					";
			$ret=mysql_query($select);
			$data=mysql_fetch_array($ret);
			$CategoryID=$data['CategoryID'];
			$CategoryName=$data['CategoryName'];
		}//Update Condition
		else if ($Action=='D') 
		{
			$delete="DELETE FROM category
					 WHERE CategoryID = '$CategoryID'
					";
			$ret=mysql_query($delete);
			if ($ret) 
			{
				echo "<script>
					window.alert('Successfully DELETED !');
					window.location='Category.php';
				  </script>";
			}
		}//Delete Condition
	}
	if (isset($_POST['btnupdate']))
	{
		echo $CategoryID = $_POST['CID'];
		echo $CategoryName = $_POST['txtcatname'];

		$Update="UPDATE category
				SET CategoryName='$CategoryName'
				WHERE CategoryID='$CategoryID'";
		$ret=mysql_query($Update);
		if ($ret)
		{
			echo "<script>
					window.alert('Successfully UPDATED !');
					window.location='Category.php';
				  </script>";
		}
	}//Update Method
?>

<?php include('Header.php') ?>
<head>
	<title>Clinic Category</title>
</head>
	<form action="" method="post">
		<input type="hidden" name="CID" value="<?php echo $CategoryID; ?>">
		<table align="center">
			<tr>
				<td><h2> Category </h2></td>
			</tr>
			<tr>
				<td>Category ID</td>
				<td><input type="text" name="txtcatID" 
					value="<?php 
					if (isset($_GET['CID'])) 
					{
						echo $CategoryID;
					}
					else
					{
						echo AutoID('Category','CategoryID','C-',6);
					} ?>" readonly></td>
			</tr>
			<tr>
				<td>Category Name</td>
				<td><input type="text" name="txtcatname" value="<?php if (isset($_GET['CID'])) {echo $CategoryName;} ?>" 
					required=""></td>
			</tr>
			<tr>
				<td></td>
				<td>
				<?php 
					if (isset($_GET['CID']))
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
		<h1 align="center">Category List</h1>
		<table align="center" width="800px" border="1">
			<tr>
				<th>Category ID</th>
				<th>Category Name</th>
			</tr>
			<?php 
				$select="SELECT * FROM category";
				$ret=mysql_query($select);
				$count=mysql_num_rows($ret);
				for ($i=0; $i <$count ; $i++) 
				{ 
					$data=mysql_fetch_array($ret);
					$CID=$data['CategoryID'];
					echo"<tr>";
					echo"<td>".$data['CategoryID']."</td>";
					echo"<td>".$data['CategoryName']."</td>";

					echo"<td><a href='Category.php?CID=$CID&Action=U'>Update</a>|
							 <a href='Category.php?CID=$CID&Action=D'>Delete</a></td>";
					echo"</tr>";
				}
			?>
		</table>
	</form>
<?php include('Footer.php') ?>