<?php
session_start();
include('connect.php');
include('AutoID_Functions.php');
include('TreatmentFunction.php');

if (isset($_REQUEST['action'])) 
{
	$Click=$_REQUEST['action'];	

	if ($Click=='ADD') 
	{
		$PurchaseID=$_REQUEST['PurchaseID'];
		$ProductID=$_REQUEST['selproductid'];
		$Quantity=$_REQUEST['Quantity'];
		$Price=$_REQUEST['Price'];

		AddProduct($PurchaseID,$ProductID,$Quantity,$Price);
	}
	if ($Click=='clear') 
	{
		ClearCart();
	}
	if ($Click=='remove') 
	{
		$ProductID=$_REQUEST['ProductID'];
		Remove_Product($ProductID);
	}
	if ($Click=='Purchase')
	{
		$PurchaseID=$_REQUEST['PurchaseID'];
		$PurchaseDate=date('Y-m-d',strtotime($_REQUEST['PDate']));
		$TotalAmount=Total_Amount();
		$SupplierID=$_REQUEST['selsupplier'];
		$ExpireDate=date('Y-m-d',strtotime($_REQUEST['txtexpiredate']));

		$insert="Insert into Purchase values('$PurchaseID','$PurchaseDate','$SupplierID','$TotalAmount')";
		$run=mysql_query($insert);

		$count=count($_SESSION['purchasecart']);
		for ($i=0; $i <$count ; $i++) 
		{ 
		  $PurchaseID=$_SESSION['purchasecart'][$i]['PurchaseID'];
		  $ProductID=$_SESSION['purchasecart'][$i]['ProductID'];
		  $PurchaseQty=$_SESSION['purchasecart'][$i]['Quantity'];
		  $PurchasePrice=$_SESSION['purchasecart'][$i]['Price'];

		  $insert="Insert into purchasedetails values ('$PurchaseID','$PurchaseQty','$PurchasePrice','$ExpireDate','$ProductID')";
		  $run=mysql_query($insert);



		  $Update1="
		  			Update Medicine
		  			set Quantity=(Quantity+$PurchaseQty)
		  			where MedicineID='$ProductID'


		  ";
		  $run1=mysql_query($Update1);


		}
		
		if ($count<1) 

		{
			echo"<script>alert('Choose Product')</script>";
		}
		else
		{
			unset($_SESSION['purchasecart']);
			echo"<script>alert('Success Purchase')</script>";
		}

	}

}
?>
<?php include('Header.php') ?>
<head>
	<title>Purchase Form</title>
</head>
	<form style="color:#000;font-weight:bold;font-size: 16px;" action='PurchaseForm.php' method='POST'>
		<fieldset>
			<legend>Purchase Form</legend>
			<table width="70%">
			<tr>
				<td>Purchase ID</td>
				<td><input type='text' name='PurchaseID' value="<?php echo AutoID('Purchase','PurchaseID','Pu_',6); ?>" readonly></td>
			</tr>

			<tr>
				<td>Purchase Date</td>
				<td><input type='text' name='PDate' value='<?php echo date('Y-m-d'); ?>' readonly></td>
			</tr>

			<tr>
				<td>Total Amount</td>
				<td><input type='text' name='TotalAmount' value='<?php 
				if (isset($_SESSION['purchasecart'])) 
				{
					echo Total_Amount();	
				}
				else
				{

					echo "0";
				}				
				?>' readonly></td>
			</tr>
		</table>
		</fieldset>	

		<fieldset>
			<legend>Choose Product</legend>
			<table width="70%">
				<tr>
					<td>Product Name</td>
					<td>
						<select name='selproductid'>
							<option>Choose Product</option>
							
								<?php 
									$query1=mysql_query("SELECT * FROM Medicine");
									$count1=mysql_num_rows($query1);
									for ($i=0; $i < $count1; $i++) { 
										$row1=mysql_fetch_array($query1);
										$MID=$row1['MedicineID'];
										$MedicineName=$row1['MedicineName'];
										echo "<option value='$MID'>$MedicineName</option>";
									}
								 ?>

							
						</select>
					</td>
				</tr>

				<tr>
					<td>Quantity</td>
					<td><input type='number' name='Quantity' placeholder='Enter Quantity'></td>
				</tr>

				<tr>
					<td>Price</td>
					<td><input type='number' name='Price' placeholder='Enter Price'></td>
				</tr>

				<tr>
					<td></td>
					<td><input type='submit' value='ADD' name='action'></td>
				</tr>

			</table>
			<br>
			<br>

			<?php

			if (isset($_SESSION['purchasecart'])) 
			{
				echo "<table width='100%'>";				
			echo "<thead style='background-color:grey'><tr>
							<td>Product ID</td>
							<td>Product Name</td>
							<td>Product Qty</td>
							<td>Product Price</td>
							<td>ExpireDate</td>
							<td>Action</td>
					</tr></thead><tbody style='background-color:lightblue'>
					";				

				$count=count($_SESSION['purchasecart']);
				for ($i=0; $i < $count ; $i++) 
				{ 
					$PurchaseID=$_SESSION['purchasecart'][$i]['PurchaseID'];
					$ProductID=$_SESSION['purchasecart'][$i]['ProductID'];
					$ProductName=$_SESSION['purchasecart'][$i]['ProductName'] ;
					$Quantity=$_SESSION['purchasecart'][$i]['Quantity'] ;
					$Price=$_SESSION['purchasecart'][$i]['Price'] ;

					echo "<tr>";					
					echo "<td>".$ProductID."</td>";
					echo "<td>".$ProductName."</td>";
					echo "<td>".$Quantity."</td>";
					echo "<td>".$Price."</td>";
					echo "<td><input style='color:red;' type='date' name='txtexpiredate'></td>";
					echo "<td align='center'><a href='PurchaseForm.php?action=remove&ProductID=".$ProductID."'><img src='images/delete.png' width='30px'></a></td>";
					echo "</tr>";		
				}

				echo "</tbody></table>";

				echo "<h2><a href='PurchaseForm.php?action=clear'>Clear</a></h2>";
			}
			else
			{
				echo "<h2>Empty Cart</h2>";
			}

			?>
			<!-- Start Combox -->
			        Supplier Name
					<select name='selsupplier'>
						<?php
						$select="Select * from Supplier";
						$run=mysql_query($select);
						$count=mysql_num_rows($run);

						for ($i=0; $i < $count ; $i++) 
						{ 
							$row=mysql_fetch_array($run);
							$SupplierID=$row['SupplierID'];
							$Supplier=$row['SupplierName'];
							echo "<option value='$SupplierID'>".$Supplier."</option>";
						}

						?>
					</select>
					<!-- End Combox -->
					<input type='submit' value='Purchase' name='action'>

		</fieldset>
	</form>
<?php include('Footer.php') ?>