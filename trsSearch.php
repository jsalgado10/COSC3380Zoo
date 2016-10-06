<?php
	ob_start();
	require_once (__DIR__.'/scripts/config.php');
?>

<?php
	echo "<style>      
	table, th, td {
		border: 2px solid black;
		border-collapse: collapse;
	}
	th, td {
		padding: 5px;
		text-align: left;    
	}
	</style>";
?>

<?php
	echo "<div id = 'title'><h1>Transaction Report</h1></div>
			<div id = 'allItems'>
			<form><label>Transactions on: </label>
			<input type='date' name='date' value='$date'/>
			<button type='submit' name='submit' value='submit'>Apply</button>
			<br/>
			</form>
			<table>
			<tr>
				<th>Transaction #</th>
				<th>Transaction Date</th>
				<th>Customer</th>
				<th>Transaction Total</th>
			</tr>";
	
			$date=$_GET['date'];
			
			
	if(empty($date))
	{
		$sql = "SELECT hdr.TransactionID,hdr.TransactionDate,c.customerFirstName,ttl.Amount FROM `Purchase_Hdr` hdr
				join customer c on c.customerID=hdr.MemberID
				join Purchase_Totals ttl on ttl.TransactionID=hdr.TransactionID
				where ttl.TotalTypeID=1 order by hdr.TransactionDate";
	}else
	{
		$sql = "SELECT hdr.TransactionID,hdr.TransactionDate,c.customerFirstName,ttl.Amount FROM `Purchase_Hdr` hdr
				join customer c on c.customerID=hdr.MemberID
				join Purchase_Totals ttl on ttl.TransactionID=hdr.TransactionID
				where ttl.TotalTypeID=1 and hdr.TransactionDate='$date' order by hdr.TransactionDate";
	}
	
	$querystmt=$DB_con->prepare($sql);
	$querystmt->execute();
	try{
		while($row=$querystmt->fetchObject()){
			echo "<tr>";
			echo "<td>{$row->TransactionID}</td>";
			echo "<td>{$row->TransactionDate}</td>";
			echo "<td>{$row->customerFirstName}</td>";
			echo "<td>{$row->Amount}</td>";
			echo "</tr>";
		}
	}
	catch(PDOException $ex){
		$user->redirect('error.php',$ex->getMessage());
	}
	echo "</table>";
?>

<?php
	$page_Content=ob_get_contents();
	ob_end_clean();
	$pagetitle="Transaction Report";
	include("master.php");
?>