<?php
session_start(); //start session
require_once (__DIR__.'/scripts/config.php');
?>
<html>
    <head>
        
    </head>
    <body>
<?php
if(isset($_POST["type"]) && $_POST["type"]=='complete')
{
    	//Add to Sales
	$salesDate=date("Y-m-d");
	$sql="Select Count(*) as salesCount from Sales where Date='$salesDate'";
	$querystmt=$DB_con->prepare($sql);
	$querystmt->execute();
	$row=$querystmt->fetchObject();
	$count=$row->salesCount;
	

	
	if($count==0)
	{
	    print 'Sales count ';
	    print $count;
	    print 'for ';
	    print $salesDate;
	    $sql="INSERT INTO `Sales`(`Date`, `TotalTypeID`, `TotalSales`) VALUES ('$salesDate',1,0),('$salesDate',2,0),('$salesDate',3,0),('$salesDate',4,0)";
	    $querystmt=$DB_con->prepare($sql);
	    $querystmt->execute();
	}
    
    //add transaction to header,details and totals
    $date=date("Y-m-d h:i:s");
    $user_id = $_SESSION['user_session'];
    if($user_id==null)
    {
        $memberid=0;
    }
    else{
    $sql="Select customerID from customer where customerID='$user_id'";
    $querystmt=$DB_con->prepare($sql);
	$querystmt->execute();
	$row=$querystmt->fetchObject();
	$memberid=$row->customerID;
    }
    
    //Add new Transaction Header
    $sql="INSERT INTO Purchase_Hdr(`TransactionDate`, `MemberID`) VALUES ('$date',$memberid)";
    $querystmt=$DB_con->prepare($sql);
    $querystmt->execute();
	
	$sql="SELECT LAST_INSERT_ID() as ID";
	$querystmt=$DB_con->prepare($sql);
	$querystmt->execute();
	$row=$querystmt->fetchObject();
	$id=$row->ID;
	
	
	//Add Transaction Details
	foreach ($_SESSION["cart_products"] as $items)
	{
	    $product_name = $items["product_name"];
        $product_qty = $items["product_qty"];
        $product_price = $items["product_price"];
        $product_code = $items["product_code"];
        $product_Amount=number_format($product_price*$product_qty,2,'.','');
        
        //print $product_code.' '.$product_name.' '.$product_qty.' '.$product_Amount.' '.$product_Amount;
        
        $sql="INSERT INTO `Purchase_Details`(`TransactionID`, `ItemID`, `ItemDesc`, `ItemQty`, `Amount`) VALUES ($id,$product_code,'$product_name',$product_qty,$product_Amount)";
        $querystmt=$DB_con->prepare($sql);
	    $querystmt->execute();
	    
	}
	
	$net=$_SESSION['net'];
	$tax=$_SESSION['tax'];
	$total=$_SESSION['total'];
	$discount=$_SESSION['discTotal'];
	
	//Add Totals
	$sql="INSERT INTO `Purchase_Totals`(`TransactionID`, `TotalTypeID`, `Amount`) VALUES ($id,1,$total),($id,2,$net),($id,3,$tax),($id,4,$discount)";
	$querystmt=$DB_con->prepare($sql);
	$querystmt->execute();
	
    //remove session values
    $_SESSION['cart_products']=NULL;
    $_SESSION['net']=NULL;
    $_SESSION['tax']=NULL;
    $_SESSION['total']=NULL;
    
    echo '<h1>Order '.$id.' processed</h1>';
}?>
</body>
<?php $page_Content=ob_get_contents(); 
	ob_end_clean(); 
	$pagetitle="Item List" ;
	include( "master.php");
?>
</html>