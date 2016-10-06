<?php
ob_start();
require_once (__DIR__.'/scripts/config.php');
if(!$user->isLoggedin())
{
	$user->redirect('login.php');
}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="site.css">
		<style>      
	
		</style>
	</head>
	<body>
		<div id = "title"><h1>Membership</h1></div>
			<div id = "search">
<?php $user->fillDropDown('membership'); ?>
	</div>
		<div id="records">
			<h1>&thinsp;Records</h1>
			<hr/>
			<?php
			
			$nameErr = $discErr = "";
			
			try 
			{
			/* Functions */
			if(isset($_GET['submit']))
			{
				$action=$_GET['submit'];
				
				if($action=='update')
				{
					$user_id = $_SESSION['user_session'];
					$id = $_GET['membership_id'];
					$name = $_GET['membership_name'];
					$discount = $_GET['member_discount'];
					
					if (empty($name))
					{
						$nameErr = 'This field cannot be empty.';
					}
					if (empty($discount))
					{
						$discErr = 'This field cannot be empty.';
					}
 					
					if(strlen($nameErr)==0 && strlen($discErr)==0)
					{
						$sql="Update membership set membershipName='$name', memberDiscount=$discount where membershipID=$id";
						$updateStm=$DB_con->prepare($sql);
						$updateStm->execute();
					}
				}
				else if($action=='delete'){
					$user_id = $_SESSION['user_session'];
					$id = $_GET['membership_id'];
					$name = $_GET['membership_name'];
					$discount = $_GET['member_discount'];
					$deleteDate=date("Y-m-d h:i:s");
					
					//Copying Record to Delete Table
					$sql="INSERT INTO `membership_del` VALUES ($id,'$name',$discount,'$deleteDate',$user_id);";
					$updateStm=$DB_con->prepare($sql);
					$updateStm->execute();
					
					//Deleting Record from Table
					$sql="Delete from membership where membershipID = $id";
					$updateStm=$DB_con->prepare($sql);
					$updateStm->execute();
				}
				else if($action=='insert'){
					$user_id = $_SESSION['user_session'];
					$id = $_GET['membership_id'];
					$name = $_GET['membership_name'];
					$discount = $_GET['member_discount'];
					$createDate=date("Y-m-d h:i:s");
					
					if (empty($name))
					{
						$nameErr = 'This field cannot be empty.';
					}
					if (empty($discount))
					{
						$discErr = 'This field cannot be empty.';
					}
					
					if(strlen($nameErr)==0 && strlen($discErr)==0)
					{
						$sql="Insert into membership VALUES(NULL, '$name', $discount, '$createDate', $user_id, '$createDate', $user_id);";
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
						$sql="Select * from membership;"; 
					}
					else
					{
						$sql="Select * from membership Where $option='$val';"; 
					}
					$querystmt=$DB_con->prepare($sql); 
					$querystmt->execute(); 			
					while($row=$querystmt->fetchObject()) 
					{ 
						echo "&ensp;<b><a href='membership.php?viewdetails={$row->membershipID}'>{$row->membershipID} {$row->membershipName}</a></b></li>";
						echo "<br/>";
					}							
				}
			}
			
			/* Output Result Page */
			$sql="Select * from membership;";
			$querystmt=$DB_con->prepare($sql);
			$querystmt->execute();
			
			while($row=$querystmt->fetchObject())
			{
				if ($action != 'search') // Otherwise will list all under query results
				{
					echo "&ensp;<b><a href='membership.php?viewdetails={$row->membershipID}'>{$row->membershipID} {$row->membershipName}</a></b></li>";
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
			$sql="Select * from membership Where membershipID=$id";
			$querystmt=$DB_con->prepare($sql);
			$querystmt->execute();
			
			$row=$querystmt->fetchObject();
			$date=date("m/d/Y");
			
			echo "<form>
			<input type='hidden' name='membership_id' value='{$row->membershipID}'/>
			&ensp;<label>Type Name: </label>
			<input type='text' name='membership_name' value='{$row->membershipName}'/>
			<span style='color:red'>* $nameErr</span>
			<br/>
			&ensp;<label>Percent Discount: </label>
			<input type='text' name='member_discount' value='{$row->memberDiscount}'/>
			<span style='color:red'>* $discErr</span>
			<br/>
			&ensp;<label>Created on: {$row->CreatedOn}</label>
			<br/>
			&ensp;<label>Updated on: {$row->LastUpdatedOn}</label>
			<br/>
			<br/>
			&emsp;<button type='submit' type='submit' name='submit' value='update'>Update</button>
			<button type='submit' type='submit' name='submit' value='delete'>Delete</button>
			<button type='button'>Cancel</button>
			</form>";
		}
		if(isset($_GET['submit'])){
			$action=$_GET['submit'];
			if($action=='new'){
			$date=date("m/d/Y");
			echo "<form>
			<label>Type Name: </label>
			<input type='text' name='membership_name' value=''/>
			<span style='color:red'>* $nameErr</span>
			<br/>
			<label>Percent Discount: </label>
			<input type='text' name='member_discount' value=''/>
			<span style='color:red'>* $discErr</span>
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
	$pagetitle="membership";
	include("master.php");
	?>
	</body>
</html>