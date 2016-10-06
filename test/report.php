<?php
	ob_start();
	require_once (__DIR__.'/scripts/config.php');
?>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="site.css">
		<style>      
			table, th, td {
		    	border: 2px solid black;
		    	border-collapse: collapse;
			}
			th, td {
		    	padding: 5px;
		    	text-align: left;    
			}
		</style>
	</head>
	<body>
		<div id = "title"><h1>Item Report</h1></div>
		<div id = "allItems">
			<table>
			<tr>
				<th>Item ID</th>
				<th>Item Name</th>
				<th>Item Type</th>
				<th>Item Price</th>
				<!--<th>Item Created On</th>
				<th>Item Created By</th>
				<th>Item Updated On</th>
				<th>Item Updated By</th>-->
			</tr>
		<?php
			/*Output Result Page */
			$sql="Select * from item, itemType where item.itemTypeID = itemType.itemTypeID;";
			$querystmt=$DB_con->prepare($sql);
			$querystmt->execute();
			
			try{
				while($row=$querystmt->fetchObject()) 
				{
					echo "<tr>";
					echo "<td>{$row->itemID}</td>";
					echo "<td>{$row->itemDescription}</td>";
					echo "<td>{$row->itemTypeName}</td>";
					echo "<td>{$row->itemPrice}</td>";
					//echo "<td>{$row->itemCreatedOn}</td>";
					//echo "<td>{$row->itemCreatedBy}</td>";
					//echo "<td>{$row->itemUpdatedOn}</td>";
					//echo "<td>{$row->itemUpdatedBy}</td>";
					echo "</tr>";
			
				}
			}
			catch(PDOException $ex)
			{
				$user->redirect('error.php',$ex->getMessage());
			}
		?>
		</table>
		</div>
	</body>
</html>