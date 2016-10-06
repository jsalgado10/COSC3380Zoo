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
		<div id = "title"><h1>Item Types</h1></div>
			<div id = "search">
				<?php $user->fillDropDown('itemType'); ?>
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
			
			$descError = "";
			
			try
			{
			/* Update */
			if(isset($_GET['submit'])){
				$action=$_GET['submit'];
				
				if($action=='update'){
				$user_id = $_SESSION['user_session'];
				$id=$_GET['itemTypeID'];
				$desc=$_GET['itemTypeName'];
				
				if(empty($desc))
					$descErr = "Name of item type is required.";
				else{
					$desc = testInput($desc);
					if(!preg_match('/^[a-zA-Z ]*$/',$desc))
						$descErr = "Only letters, spaces allowed.";
				}
				
				if(strlen($descErr) == 0){
					$sql="update itemType set itemTypeName='$desc', itemTypeUpdatedBy=$user_id where itemTypeID=$id;";
					$updateStm=$DB_con->prepare($sql);
					$updateStm->execute();
				}
				}
				else if($action=='delete'){
					$user_id = $_SESSION['user_session'];
					$id=$_GET['itemTypeID'];
					$desc=$_GET['itemTypeName'];
					$deleteDate=date("Y-m-d h:i:s");
					
					//Copying Record to Delete Table
					$sql="INSERT INTO `itemType_Del` (`itemTypeID`,`itemTypeName`,`itemTypeDeletedOn`,`itemTypeDeletedBy`) VALUES ($id,'$desc','$deleteDate',$user_id);";
					$updateStm=$DB_con->prepare($sql);
					$updateStm->execute();
					
					//Deleting Record from Table
					$sql="Delete from itemType where itemTypeID = $id";
					$updateStm=$DB_con->prepare($sql);
					$updateStm->execute();
				}
				else if($action=='insert'){
					$user_id = $_SESSION['user_session'];
					$id=$_GET['itemTypeID'];
					$desc=$_GET['itemTypeName'];
					$createDate=date("Y-m-d h:i:s");
					
					if(empty($desc))
						$descErr = "Name of item type is required.";
					else{
						$desc = testInput($desc);
						if(!preg_match('/^[a-zA-Z ]*$/',$desc))
							$descErr = "Only letters, spaces allowed.";
					}
					
					if(strlen($descErr) == 0){
						$sql="Insert into itemType VALUES(NULL,'$desc','$createDate',$user_id,'$createDate',$user_id);";
						$updateStm=$DB_con->prepare($sql);
						$updateStm->execute();
					}
				}
				else if($action=='search')
				{
					/*Output Result Page */
					$option=$_GET['soption'];
					$val=$_GET['searchVal'];
					if($val=="")
					{
						$sql="Select * from itemType;"; 
					}
					else
					{
						$sql="Select * from itemType Where $option like '%{$val}%';"; 
					}
					$querystmt=$DB_con->prepare($sql); 
					$querystmt->execute(); 			
					while($row=$querystmt->fetchObject()) 
					{ 
						echo "&ensp;<b><a href='itemTypeSearch.php?viewdetails={$row->itemTypeID}'>{$row->itemTypeID} {$row->itemTypeName}</a></b></li>";
						echo "<br/>";
					}							
				}
			}


			
			/*Output Result Page */
			$sql="Select * from itemType;";
			$querystmt=$DB_con->prepare($sql);
			$querystmt->execute();
			
			while($row=$querystmt->fetchObject()) {
				if ($action != 'search')
				{
					echo "&ensp;<b><a href='itemTypeSearch.php?viewdetails={$row->itemTypeID}'>{$row->itemTypeID} {$row->itemTypeName}</a></b></li>";
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
			<h1>Details</h1>
			<hr/>
		<?php 
		try
		{
		if(isset($_GET['viewdetails'])){
			$id=$_GET['viewdetails'];
			$sql="Select * from itemType Where itemTypeID=$id";
			$querystmt=$DB_con->prepare($sql);
			$querystmt->execute();
			$row=$querystmt->fetchObject();
			echo "<form>
			<input type='hidden' name='itemTypeID' value='{$row->itemTypeID}'/>
			&ensp;<label>Name: </label>
			<input type='text' name='itemTypeName' value='{$row->itemTypeName}'/>
			<br/>
			&ensp;<label>Created on: {$row->itemTypeCreatedOn}</label>
			<br/>
			&ensp;<label>Updated on: {$row->itemTypeUpdatedOn}</label>
			<br/>
			</br>
			&emsp;<button type='submit' type='submit' name='submit' value='update'>Update</button>
			<button type='submit' type='submit' name='submit' value='delete'>Delete</button>
			<button type='button'>Cancel</button>
			</form>";
		}
		if(isset($_GET['submit'])){
			$action=$_GET['submit'];
			if($action=='new' || $action == 'insert'){
			$date=date("m/d/Y");
			echo "<form>
			&ensp;<label>Name: </label>
			<input type='text' name='itemTypeName' value=''/>
			<br/>
			<span style='color:red'>* $descErr</span>
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
	$pagetitle="Item Type";
	include("master.php");
	?>
	</body>
</html>