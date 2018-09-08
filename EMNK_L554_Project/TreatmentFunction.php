<?php
Function AddProduct($TreatmentID,$ProductID,$Quantity,$Price)
{
	$select1="SELECT * FROM Medicine WHERE MedicineID = '$ProductID'
			";//copy from home page

	$run1=mysql_query($select1);
	$count1=mysql_num_rows($run1);
	$row=mysql_fetch_array($run1);
	$ProductName=$row['MedicineName'];


	
			if(isset($_SESSION['MedicineCart']))
			{
				$size=count($_SESSION['MedicineCart']);
				$index=Check_ProductID($ProductID);

				if ($index!=-1) 
				{
					$_SESSION['MedicineCart'][$index]['Quantity']+= $Quantity;
				}
				if ($index==-1) 
				{
				$_SESSION['MedicineCart'][$size]['TreatmentID'] = $TreatmentID;				
				$_SESSION['MedicineCart'][$size]['ProductID'] = $ProductID;
				$_SESSION['MedicineCart'][$size]['ProductName'] = $ProductName;
				$_SESSION['MedicineCart'][$size]['Quantity'] = $Quantity;
				$_SESSION['MedicineCart'][$size]['Price'] = $Price;	
				}
					
			}
//--------------------------------------------------------------------------------------------		
			else
			{
				$_SESSION['MedicineCart'] = array();
				$_SESSION['MedicineCart'][0]['TreatmentID'] = $TreatmentID;				
				$_SESSION['MedicineCart'][0]['ProductID'] = $ProductID;
				$_SESSION['MedicineCart'][0]['ProductName'] = $ProductName;
				$_SESSION['MedicineCart'][0]['Quantity'] = $Quantity;
				$_SESSION['MedicineCart'][0]['Price'] = $Price;				
			}
//-------------------------------------------------------------------------------------------------
			echo "<script>window.location='TreatmentForm.php'</script>";
}

Function Check_ProductID($PID)//0
{	
	$size=count($_SESSION['MedicineCart']);
	for ($i=0; $i < $size ; $i++) 
	{ 
		$SeProductID=$_SESSION['MedicineCart'][$i]['ProductID'] ;
		if ($SeProductID==$PID) 
		{
			return $i;
		}
	}
	return -1;
}

Function ClearCart()
{
	unset($_SESSION['MedicineCart']);
}

Function Remove_Product($PID)
{
	$index=Check_ProductID($PID);
	unset($_SESSION['MedicineCart'][$index]);
	$_SESSION['MedicineCart']=array_values($_SESSION['MedicineCart']);
}

Function Total_Amount($charges)
{
	$Total=0;

	$size=count($_SESSION['MedicineCart']);
	for ($i=0; $i < $size ; $i++) 
	{ 
		
		$Price=$_SESSION['MedicineCart'][$i]['Price'];	
		$Total=$Total+$Price;
	}
	return $Total+$charges;
}


?>