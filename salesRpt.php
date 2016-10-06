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
	echo "<div id = 'title'><h1>Sales Report</h1></div>
			<div id = 'allItems'>
			<form><label>Sales on: </label>
			<input type='date' name='date' value=''/>
			<button type='submit' name = 'submit'>Print Report</button>
			<br/>
			</form>
			<table>
			<tr>
				<th>Date</th>
				<th>Sale Type</th>
				<th>Sale Amount</th>
			</tr>";
	
	if(isset($_GET['submit'])){
		$selectedDate = $_GET['date'];
	}		
	if(empty($selectedDate))
		$sql = "Select Date, ttl.TotalTypeName, TotalSales from Sales s join Totals_Type ttl on ttl.TotalTypeID=s.TotalTypeID order by Date asc;";
	else
		$sql = "Select Date, ttl.TotalTypeName, TotalSales from Sales s join Totals_Type ttl on ttl.TotalTypeID=s.TotalTypeID where Date = '{$selectedDate}' order by Date asc;";
	$querystmt=$DB_con->prepare($sql);
	$querystmt->execute();
	try{
		while($row=$querystmt->fetchObject()){
			echo "<tr>";
			echo "<td>{$row->Date}</td>";
			echo "<td>{$row->TotalTypeName}</td>";
			echo "<td>{$row->TotalSales}</td>";
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
	$pagetitle="Sales Report";
	include("master.php");
?>