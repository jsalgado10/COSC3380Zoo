<?php
ob_start();
require_once (__DIR__.'/scripts/config.php');
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="site.css">
		<style>      

		</style>
	</head>
	<body>
		<div id = "title"><h1>Items</h1></div>
			<div id = "search">
				<?php $user->fillDropDown('item'); ?>
			</div>
		<div id="records">
			<h1>&thinsp;Results</h1>
			<hr/>
			<?php
			
			function testInput($data){
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}
			
			$descErr = $typeErr = $priceErr = "";
			
			try
			{
			/* Update */
			if(isset($_GET['submit'])){
				$action=$_GET['submit'];
				
				if($action=='update'){
				$user_id = $_SESSION['user_session'];
				$id=$_GET['itemID'];
				$desc=$_GET['itemDescription'];
				$typeid=$_GET['itemTypeID'];
				$price=$_GET['itemPrice'];
				
				if(empty($desc))
					$descErr = "Description of item is required.";
				else{
					$desc = testInput($desc);
					if(!preg_match('/^[a-zA-Z ]*$/',$desc))
						$descErr = "Only letters, spaces allowed.";
				}
					
				if(empty($typeid))
					$typeErr = "Item type is required.";
				else{
					$typeID = testInput($typeid);
					if(!is_numeric($typeid))
						$typeErr = "Only numbers allowed.";
				}
					
				if(empty($price))
					$priceErr = "Price is required.";
				else{
					$price = testInput($price);
					if(!is_numeric($price))
						$priceErr = "Invalid price.";
					else
						$price = round($price,2,PHP_ROUND_HALF_DOWN);
				}
				if((strlen($descErr)==0 && strlen($typeErr)==0) && strlen($priceErr) == 0){
					$sql="update item set itemDescription='$desc',itemPrice=$price, itemTypeID=$typeid, itemUpdatedBy=$user_id where itemID=$id;";
					$updateStm=$DB_con->prepare($sql);
					$updateStm->execute();
				}
				}
				else if($action=='delete'){
					$user_id = $_SESSION['user_session'];
					$id=$_GET['itemID'];
					$desc=$_GET['itemDescription'];
					$typeid=$_GET['itemTypeID'];
					$price=$_GET['itemPrice'];
					$deleteDate=date("Y-m-d h:i:s");
					
					//Copying Record to Delete Table
					$sql="INSERT INTO `item_Del` (`itemID`,`itemDescription`,`itemTypeID`,`itemPrice`,`itemDeletedOn`,`itemDeletedBy`) VALUES ($id,'$desc',$typeid,'$price','$deleteDate',$user_id);";
					$updateStm=$DB_con->prepare($sql);
					$updateStm->execute();
					
					//Deleting Record from Table
					$sql="Delete from item where itemID = $id";
					$updateStm=$DB_con->prepare($sql);
					$updateStm->execute();
				}
				else if($action=='insert'){
					$user_id = $_SESSION['user_session'];
					$id=$_GET['itemID'];
					$desc=$_GET['itemDescription'];
					$typeid=$_GET['itemTypeID'];
					$price=$_GET['itemPrice'];
					$createDate=date("Y-m-d h:i:s");
					
					if(empty($desc))
						$descErr = "Description of item is required.";
					else{
						$desc = testInput($desc);
						if(!preg_match('/^[a-zA-Z ]*$/',$desc))
							$descErr = "Only letters, spaces allowed.";
					}
					
					if(empty($typeid))
						$typeErr = "Item type is required.";
					else{
						$typeID = testInput($typeid);
						if(!is_numeric($typeid))
							$typeErr = "Only numbers allowed.";
					}
					
					if(empty($price))
						$priceErr = "Price is required.";
					else{
						$price = testInput($price);
						if(!is_numeric($price))
							$priceErr = "Invalid price.";
						else
							$price = round($price,2,PHP_ROUND_HALF_DOWN);
					}
					if((strlen($descErr)==0 && strlen($typeErr)==0) && strlen($priceErr) == 0){
						$sql="Insert into item VALUES(NULL,'$desc', $typeid ,$price,'$createDate',$user_id,'$createDate',$user_id);";
						$updateStm=$DB_con->prepare($sql);
						$updateStm->execute();
					}
				}
				else if($action=='search')
				{
					/*Output Result Page */
					$option=$_GET['soption'];
					$val= $_GET['searchVal'];
					if($val=="")
					{
						$sql="Select * from item;"; 
					}
					else
					{
						$sql="Select * from item Where $option like '%{$val}%';"; 
					}
					$querystmt=$DB_con->prepare($sql); 
					$querystmt->execute(); 			
					while($row=$querystmt->fetchObject()) 
					{ 
						echo "&ensp;<b><a href='itemSearch.php?viewdetails={$row->itemID}'>{$row->itemID} {$row->itemDescription}</a></b></li>";
						echo "<br/>";
					}							
				}
			}
			

			
			/*Output Result Page */
			$sql="Select * from item;";
			$querystmt=$DB_con->prepare($sql);
			$querystmt->execute();
			
			while($row=$querystmt->fetchObject()) 
			{
				if ($action != 'search')
				{
					echo "&ensp;<b><a href='itemSearch.php?viewdetails={$row->itemID}'>{$row->itemID} {$row->itemDescription}</a></b></li>";
					echo "<br/>";
				}
			}
			
			}
			catch(PDOException $ex)
			{
				$user->redirect('error.php',$ex->getMessage());
			}
			?>
			</br>
			<form>
				&emsp;<button type='submit' type='submit' name='submit' value='new'>Add New</button>
			</form>
		</div>
	<div id="details">
			<h1>&thinsp;Details</h1>
			<hr/>
		<?php 
		try
		{
		if(isset($_GET['viewdetails'])){
			$id=$_GET['viewdetails'];
			$sql="Select * from item Where itemID=$id";
			$querystmt=$DB_con->prepare($sql);
			$querystmt->execute();
			$row=$querystmt->fetchObject();
			echo "<form>
			<input type='hidden' name='itemID' value='{$row->itemID}'/>
			&ensp;<label>Description: </label>
			<input type='text' name='itemDescription' value='{$row->itemDescription}'/>
			<br/>
			&ensp;<label>Item Type: </label>
			<select name='itemTypeID'>";
			
			$sql2 = "select itemTypeID, itemTypeName from itemType;";
			$querystmt2=$DB_con->prepare($sql2);
			$querystmt2->execute();
			while($row2 = $querystmt2->fetchObject()) {
				if($row2->itemTypeID == $row->itemTypeID)
					echo "<option value = '{$row2->itemTypeID}' selected = 'true'>{$row2->itemTypeName}</option>";
				else
					echo "<option value = '{$row2->itemTypeID}'>{$row2->itemTypeName}</option>";
			}
			echo "</select>
			<br/>
			&ensp;<label>Item Price: </label>
			<input type='text' name='itemPrice' value='{$row->itemPrice}'/>
			<br/>
			&ensp;<label>Created on: {$row->itemCreatedOn}</label>
			<br/>
			&ensp;<label>Updated on: {$row->itemUpdatedOn}</label>
			<br/>
			</br>
			&emsp;<button type='submit' type='submit' name='submit' value='update'>Update</button>
			<button type='submit' type='submit' name='submit' value='delete'>Delete</button>
			<button type='button'>Cancel</button>
			</form>";
		}
		if(isset($_GET['submit'])){
			$action=$_GET['submit'];
			if($action=='new' || $action =='insert'){
			$date=date("m/d/Y");
			echo "<form>
			&ensp;<label>Description: </label>
			<input type='text' name='itemDescription' value=''/>
			<span style='color:red'>* $descErr</span>
			<br/>
			&ensp;<label>Item Type: </label>
			<select name='itemTypeID'>";
			
			$sql2 = "select itemTypeID, itemTypeName from itemType;";
			$querystmt2=$DB_con->prepare($sql2);
			$querystmt2->execute();
			while($row2 = $querystmt2->fetchObject()) {
				if($row2->itemTypeID == $row->itemTypeID)
					echo "<option value = '{$row2->itemTypeID}' selected = 'true'>{$row2->itemTypeName}</option>";
				else
					echo "<option value = '{$row2->itemTypeID}'>{$row2->itemTypeName}</option>";
			}
			echo "</select>
			<br/>
			&ensp;<label>Item Price: </label>
			<input type='text' name='itemPrice' value=''/>
			<span style='color:red'>* $priceErr</span>
			<br/>
			</br>
			&emsp;<button type='submit' type='submit' name='submit' value='insert'>Insert</button>
			</form>";
			}
		}
		
		}
		catch(PDOException $ex)
		{
			$user->redirect('error.php');
		}
		?>

	</div>
	<?php
	$page_Content=ob_get_contents();
	ob_end_clean();
	$pagetitle="Item";
	include("master.php");
	?>
	</body>
</html>