<?php
	include('Connect.php');
	include('AutoID_Functions.php');
	if (isset($_POST['btnsave']))
	{
		$AIID = $_POST['txtaiID'];
		$AIName = $_POST['txtainame'];

		$insert = "INSERT INTO activeIngredient
				   VALUES ('$AIID','$AIName')";
		$ret = mysql_query($insert);
		if ($ret)
		{
			echo "<script>
					window.alert('Successfully saved for ActiveIngredient !');
					window.location='ActiveIngredient.php';
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
				<td><h2> Active Ingredient Register </h2></td>
			</tr>
			<tr>
				<td>Active Ingredient ID</td>
				<td><input type="text" name="txtaiID" 
					value="<?php
							if (isset($_GET['AIID'])) 
							{
								echo $AIID;
							}
							else
							{
								echo AutoID('ActiveIngredient','AIID','AI-',6);
							} ?>" readonly></td>
			</tr>
			<tr>
				<td>Active Ingredient Name</td>
				<td><input type="text" name="txtainame" value="<?php if (isset($_GET['AIID'])) {echo $AIName;} ?>" 		required=""></td>
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
		<h1 align="center">Active Ingredient List</h1>
		<table align="center" width="800px" border="1">
			<tr>
				<th>Active Ingredient ID</th>
				<th>Active Ingredient Name</th>
			</tr>
			<?php 
				$select="SELECT * FROM activeingredient";
				$ret=mysql_query($select);
				$count=mysql_num_rows($ret);
				for ($i=0; $i <$count ; $i++) 
				{ 
					$data=mysql_fetch_array($ret);
					$AIID=$data['AIID'];
					echo"<tr>";
					echo"<td>".$data['AIID']."</td>";					
					echo"<td>".$data['ActiveIngredientName']."</td>";
					echo"<td><a href='ActiveIngredient.php?AIID=$AIID&Action=U'>Update</a>|
							 <a href='ActiveIngredient.php?AIID=$AIID&Action=D'>Delete</a></td>";
					echo"</tr>";
				}
			?>
		</table>
	</form>
</body>
</html>