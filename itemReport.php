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
		<div id = "selector" type = "submit"><form><select name = "selector">
			<option value = "descA">Description (ascending)</option>
			<option value = "descD">Description (descending)</option>
			<option value = "priceA">Price (ascending)</option>
			<option value = "priceD">Price (descending)</option>
			<?php 
			$sql="Select itemTypeID, itemTypeName from itemType;";
			$querystmt=$DB_con->prepare($sql);
			$querystmt->execute();
			try{
				while($row=$querystmt->fetchObject()){
					echo "<option value = {$row->itemTypeID}>{$row->itemTypeName}</option>";
				}
			}
			catch(PDOException $ex)
			{
				$user->redirect('error.php',$ex->getMessage());
			}
			?>
		</select>
		<button type='submit' name='submit' value='selector'>Print Report</button>
		</form></div>
		<div id = "allItems">
			<table>
			<tr>
				<th>Item Name</th>
				<th>Item Type</th>
				<th>Item Price</th>
			</tr>
		<?php
			/*Output Result Page */
			function selectReport($data){
				$returnString = "";
				if($data == "descA")
					$returnString = " ORDER BY item.itemDescription ASC;";
				else if($data == "descD")
					$returnString = " ORDER BY item.ItemDescription DESC";
				else if($data == "priceA")
					$returnString = " ORDER BY item.ItemPrice ASC";
				else if($data == "priceD")
					$returnString = " ORDER BY item.ItemPrice DESC";
				else
					$returnString = " AND item.itemTypeID = '$data' ORDER BY item.ItemDescription ASC";
				return $returnString;
			}
			
			$sql="Select * from item, itemType where item.itemTypeID = itemType.itemTypeID";
			if(isset($_GET['submit']))
				$selectedRep = $_GET['selector'];
			else
				$selectedRep = 0;
			$sql = $sql.selectReport($selectedRep);
			$querystmt=$DB_con->prepare($sql);
			$querystmt->execute();
			
			try{
				while($row=$querystmt->fetchObject())
				{
					echo "<tr>";
					echo "<td>{$row->itemDescription}</td>";
					echo "<td>{$row->itemTypeName}</td>";
					echo "<td>{$row->itemPrice}</td>";
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
		<?php $page_Content=ob_get_contents(); ob_end_clean(); $pagetitle="Item Report" ; include( "master.php"); ?>
	</body>
</html>