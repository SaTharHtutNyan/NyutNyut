<?php 
	include('Connect.php');
	if (isset($_POST['btnlogin'])) 
	{
		$Email = $_POST['txtemail'];
		$Password = $_POST['txtpassword'];

		$select = "SELECT * FROM staff WHERE Email='$Email' AND Password='$Password'";
		$ret = mysql_query($select);
		$count = mysql_num_rows($ret);
		if($count>0)
		{
			echo "<script>window.alert('Successfully Login')</script>";
			echo "<script>window.location='Patient.php'</script>";
		}
		else
		{
			echo "<script>window.alert('Incorrect Login ! Please Login Again !')</script>";
		}
	}
?>
<?php include('Header.php') ?>
<head>
	<title>KYAW Clinic</title>
</head>
	<h1 align="center"> Login Form </h1>
	<form action="" method="post">
	<table align="center">
	<tr>
		<td>Email</td>
		<td>: :</td>
		<td><input type="text" name="txtemail" required></td>
	</tr>
	<tr>
		<td>Password</td>
		<td>: :</td>
		<td><input type="Password" name="txtpassword" required></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="btnlogin" value="Login" ></td>
		<td><input type="reset" name="btncancle" value="Cancle" ></td>
	</tr>
	</table>
	</form>
<?php include('Footer.php') ?>
