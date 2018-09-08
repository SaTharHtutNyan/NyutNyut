<?php
Function AddProduct($PurchaseID,$ProductID,$Quantity,$Price)
{
	$select1="SELECT * FROM Medicine WHERE MedicineID = '$ProductID'
			";//copy from home page

	$run1=mysql_query($select1);
	$count1=mysql_num_rows($run1);
	$row=mysql_fetch_array($run1);
	$ProductName=$row['MedicineName'];


	
			if(isset($_SESSION['purchasecart']))
			{
				$size=count($_SESSION['purchasecart']);
				$index=Check_ProductID($ProductID);

				if ($index!=-1) 
				{
					$_SESSION['purchasecart'][$index]['Quantity']+= $Quantity;
				}
				if ($index==-1) 
				{
				$_SESSION['purchasecart'][$size]['PurchaseID'] = $PurchaseID;				
				$_SESSION['purchasecart'][$size]['ProductID'] = $ProductID;
				$_SESSION['purchasecart'][$size]['ProductName'] = $ProductName;
				$_SESSION['purchasecart'][$size]['Quantity'] = $Quantity;
				$_SESSION['purchasecart'][$size]['Price'] = $Price;	
				}
					
			}
//--------------------------------------------------------------------------------------------		
			else
			{
				$_SESSION['purchasecart'] = array();
				$_SESSION['purchasecart'][0]['PurchaseID'] = $PurchaseID;				
				$_SESSION['purchasecart'][0]['ProductID'] = $ProductID;
				$_SESSION['purchasecart'][0]['ProductName'] = $ProductName;
				$_SESSION['purchasecart'][0]['Quantity'] = $Quantity;
				$_SESSION['purchasecart'][0]['Price'] = $Price;				
			}
//-------------------------------------------------------------------------------------------------
}

Function Check_ProductID($PID)//0
{	
	$size=count($_SESSION['purchasecart']);
	for ($i=0; $i < $size ; $i++) 
	{ 
		$SeProductID=$_SESSION['purchasecart'][$i]['ProductID'] ;
		if ($SeProductID==$PID) 
		{
			return $i;
		}
	}
	return -1;
}

Function ClearCart()
{
	unset($_SESSION['purchasecart']);
}

Function Remove_Product($PID)
{
	$index=Check_ProductID($PID);
	unset($_SESSION['purchasecart'][$index]);
	$_SESSION['purchasecart']=array_values($_SESSION['purchasecart']);
}

Function Total_Amount()
{
	$Total=0;

	$size=count($_SESSION['purchasecart']);
	for ($i=0; $i < $size ; $i++) 
	{ 
		 $Quantity=$_SESSION['purchasecart'][$i]['Quantity'];
		$Price=$_SESSION['purchasecart'][$i]['Price'];	
		$Total=$Total+($Quantity*$Price);
	}
	return $Total;
}


?>