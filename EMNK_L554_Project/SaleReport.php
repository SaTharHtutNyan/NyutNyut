<?php 
	include('Connect.php');

	if (isset($_POST['btnsearch'])) 
	{

	}
	elseif (isset($_POST['btnsearchall'])) 
	{		
		$select="SELECT * 
				 FROM Supplier s, Purchase p, PurchaseDetails pd, ActiveIngredient ai, DosageForm df
				 WHERE p.PurchaseID = pd.PurchaseID
				 AND s.SupplierID = p.SupplierID
				 AND ai.AIID = pd.ProductID
				 AND df.DosageFormID = pd.ProductID
				 AND p.PurchaseDate ='$todaydate'
				";
		$ret=mysql_query($select) or die(mysql_error());
	}
	else
	{	
		echo $todaydate=date('Y-m-d');
		$select="SELECT * 
				 FROM Supplier s, Purchase p, PurchaseDetails pd, ActiveIngredient ai, DosageForm df, category c
				 WHERE p.PurchaseID = pd.PurchaseID
				 AND s.SupplierID = p.SupplierID
				 AND c.CategoryID=ai.CategoryID
				 AND c.CategoryID=df.CategoryID
				 AND ai.AIID = pd.ProductID
				 AND df.DosageFormID = pd.ProductID
				 AND p.PurchaseDate ='$todaydate'
				";
		$ret=mysql_query($select) or die(mysql_error());
	}
?>
<html>
<head>
	<title>Sales Report</title>
</head>
<body>
<form action="" method="post">
<table align="center">
	<tr>
		<td><input type="radio" name="rdosearch" value="PDate" checked>Search by PURCHASE DATE</td>
		<td><input type="radio" name="rdosearch" value="SName">Search by SUPPLIER NAME</td>
		<td><input type="radio" name="rdosearch" value="AIName">Search by ACTIVE INGREDIENT NAME</td>
		<td><input type="radio" name="rdosearch" value="DFName">Search by DOSAGE FORM NAME</td>
	</tr>
	<tr>
		<td><input type="date" name="txtpurchasedate"></td>
		<td><input type="text" name="txtsuppliername"></td>
		<td><input type="text" name="txtainame"></td>
		<td><input type="text" name="txtdfname"></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" name="btnsearch" value="Search"></td>
		<td><input type="submit" name="btnsearchall" value="Search ALL"></td>
		<td><input type="submit" name="btnclear" value="Clear"></td>
	</tr>
</table>
</form>
	<table align="center" border="1">
	<tr>
		<td>Supplier Name</td>
		<td>Purchase Date</td>
		<td>ActiveIngredient Name</td>
		<td>DosageForm Name</td>
		<td>Quantity</td>
		<td>Total Amount</td>
		<td>Expire Date</td>
	</tr>
<?php 
	$count=mysql_num_rows($ret);
	for ($i=0; $i < $count; $i++) 
	{ 
		$data=mysql_fetch_array($ret);
		echo "<tr>
				<td>".$data['SupplierName']."</td>
				<td>".$data['PurchaseDate']."</td>
				<td>".$data['ActiveIngredient']."</td>
				<td>".$data['DosageFormName']."</td>
				<td>".$data['Quantity']."</td>
				<td>".$data['TotalAmount']."</td>
				<td>".$data['ExpireDate']."</td>
			  </tr>";
	}
?>
	</table>
</body>
</html>