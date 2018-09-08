<?php
session_start();
include('connect.php');
include('AutoID_Functions.php');
include('TreatmentFunction.php');
	if(isset($_GET['TNO']))
	{
		$TNO=$_GET['TNO'];
		$_SESSION['TNO']=$_GET['TNO'];
	}
if (isset($_REQUEST['action'])) 
{
	$Click=$_REQUEST['action'];	

	if ($Click=='ADD') 
	{
		$TreatmentID=$_REQUEST['TreatmentID'];
		$ProductID=$_REQUEST['selproductid'];
		$Quantity=$_REQUEST['Quantity'];
		$Price=$_REQUEST['Price'];

		AddProduct($TreatmentID,$ProductID,$Quantity,$Price);
	}
	else if ($Click=='clear') 
	{
		ClearCart();
	}
	else if ($Click=='remove') 
	{
		$ProductID=$_REQUEST['ProductID'];
		Remove_Product($ProductID);
	}
	else if ($Click=='Paid')
	{
		$TreatmentID=$_REQUEST['TreatmentID'];
		$Charges=$_REQUEST['txtcharges'];
		$TreatmentDate=date('Y-m-d',strtotime($_REQUEST['txttreatmentdate']));
		$TotalAmount=Total_Amount($Charges);
		$TokenNo=$_REQUEST['txtTNO'];
		$NextAppDate = $_POST['txtnextappdate'];

		

		$count=count($_SESSION['MedicineCart']);
		for ($i=0; $i <$count ; $i++) 
		{ 
		  $TreatmentID=$_SESSION['MedicineCart'][$i]['TreatmentID'];
		  $ProductID=$_SESSION['MedicineCart'][$i]['ProductID'];
		  $PurchaseQty=$_SESSION['MedicineCart'][$i]['Quantity'];
		  $PurchasePrice=$_SESSION['MedicineCart'][$i]['Price'];

		  $insert="Insert into MedicineUsage values ('$TreatmentID','$ProductID','$PurchaseQty','$PurchasePrice')";
		  $run=mysql_query($insert);



		  $Update1="
		  			Update Medicine
		  			set Quantity=(Quantity-$PurchaseQty)
		  			where MedicineID='$ProductID'


		  ";
		  $run1=mysql_query($Update1);


		}
		$insert="Insert into Treatment values('$TreatmentID','$TokenNo','$Charges','$TreatmentDate','$TotalAmount')";
		$run=mysql_query($insert);
		$update = "UPDATE Appointment SET AppointmentDate='$NextAppDate' WHERE TokenNo='$TokenNo' AND TokenDate='$TreatmentDate'";
		$ret1 = mysql_query($update);
		
		if ($count<1) 

		{
			echo"<script>alert('Choose Product')</script>";
		}
		else
		{
			unset($_SESSION['MedicineCart']);
			unset($_SESSION['TNO']);
			echo"<script>alert('Paid Success')</script>";
		}

	}

}
?>
<?php include('Header.php') ?>
<head>
	<title>Purchase Form</title>
</head>
	<form style="color:#000;font-weight:bold;font-size: 16px;" action='TreatmentForm.php' method='POST'>
		<fieldset>
			<legend>Treatment Form</legend>
			

			<table width="50%" align="center">

			<tr>
				<td>Treatment ID</td>
				<td><input type="text" name="TreatmentID" 
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
				<td><input type="text" name="txtTNO" value="<?php if(isset($_SESSION['TNO'])){echo $a=$_SESSION['TNO'];} ?>" readonly></td>
			</tr>
			<tr>
				<td>Charges</td>
				<td><input type="text" name="txtcharges"></td>
			</tr>
			<tr>
				<td>Treatment Date</td>
				<td><input type="Date" name="txttreatmentdate" value="<?php echo date('Y-m-d') ?>" readonly></td>
			</tr>
			<tr>
				<td>Next Appointment Date</td>
				<td><input type="Date" name="txtnextappdate" value="<?php echo date('Y-m-d'); ?>"></td>
			</tr>
			
			
		</table>
		</fieldset>	

		<fieldset>
			<legend>Choose Medicine</legend>
			<table width="50%" align="center">
				<tr>
					<td>Medicine Name</td>
					<td>
						<select name='selproductid'>
							<option>Choose Medicine</option>
							
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

			if (isset($_SESSION['MedicineCart'])) 
			{
				echo "<table width='100%'>";				
			echo "<thead style='background-color:grey'><tr>
							<td>Product ID</td>
							<td>Product Name</td>
							<td>Product Qty</td>
							<td>Product Price</td>
							<td>Action</td>
					</tr></thead><tbody style='background-color:lightblue'>
					";				

				$count=count($_SESSION['MedicineCart']);
				for ($i=0; $i < $count ; $i++) 
				{ 
					$TreatmentID=$_SESSION['MedicineCart'][$i]['TreatmentID'];
					$ProductID=$_SESSION['MedicineCart'][$i]['ProductID'];
					$ProductName=$_SESSION['MedicineCart'][$i]['ProductName'] ;
					$Quantity=$_SESSION['MedicineCart'][$i]['Quantity'] ;
					$Price=$_SESSION['MedicineCart'][$i]['Price'] ;

					echo "<tr>";					
					echo "<td>".$ProductID."</td>";
					echo "<td>".$ProductName."</td>";
					echo "<td>".$Quantity."</td>";
					echo "<td>".$Price."</td>";
					echo "<td align='center'><a href='TreatmentForm.php?action=remove&ProductID=".$ProductID."'><img src='images/delete.png' width='30px'></a></td>";
					echo "</tr>";		
				}

				echo "</tbody></table>";

				echo "<h2><a href='TreatmentForm.php?action=clear'>Clear</a></h2>";
			}
			else
			{
				echo "<h2>Empty Cart</h2>";
			}

			?>
			
			<h2>Total Amount
				
				<?php 
				if (isset($_SESSION['MedicineCart'])) 
				{
					$Totalamount=0;
					$count=count($_SESSION['MedicineCart']);
					for ($i=0; $i < $count ; $i++) 
					{ 
						 $Totalamount=($Totalamount+$_SESSION['MedicineCart'][$i]['Price']);
						
					}	
					 echo $Totalamount;
				}
				else
				{

					echo "0";
				}				
				?>

			</h2>
			

					<input type='submit' value='Paid' name='action'>

		</fieldset>
	</form>
<?php include('Footer.php') ?>