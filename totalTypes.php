<?php ob_start(); require_once (__DIR__. '/scripts/config.php');?>
<html>

<head>
	
</head>

<body>
	<div id="title">
		<h1>Totalizers</h1>
	</div>
	<div id="search">
		<?php $user->fillDropDown('Totals_Type'); ?>
	</div>
	<div id="records">
		<div id="title">
		<h1>&thinsp;Results</h1>
		<hr/>
		</div>
		<?php 
		try 
		{ 
			

			
			
			/* Update */ 
			if(isset($_GET[ 'submit']))
			{ 
				$action=$_GET[ 'submit']; 
				if($action=='update' )			
				{ 
					$user_id=$_SESSION[ 'user_session']; 
					$id=$_GET[ 'totalid']; 
					$desc=$_GET[ 'totalDesc']; 
					$sql="update Totals_Type set TotalTypeName='$desc', UpdateBy=$user_id where TotalTypeID=$id;";
					$updateStm=$DB_con->prepare($sql); 
					$updateStm->execute(); 
				} 
				//Delete 
				else if($action=='delete')
				{ 
					$user_id = $_SESSION['user_session']; 
					$id=$_GET['totalid']; 
					$desc=$_GET['totalDesc']; 
					$deleteDate=date("Y-m-d h:i:s");
					//Copying Record to Delete Table 
					$sql="Insert into Totals_Type_Del VALUES($id,'$desc','$deleteDate',$user_id);";
					$updateStm=$DB_con->prepare($sql);
					$updateStm->execute();
					//Deleting Record from Table 
					$sql="Delete From Totals_Type where TotalTypeID=$id";
					$updateStm=$DB_con->prepare($sql);
					$updateStm->execute();
				} 
					//Insert New Record 
				else if($action=='insert')
				{ 
					$user_id = $_SESSION['user_session']; //this is the userid
					$desc=$_GET['totalDesc']; //this it the description
					$createDate=date("Y-m-d h:i:s"); //here i get the current datetime in format YY-MM-DD HH:mm:ss
					$sql="Insert into Totals_Type VALUES(NULL,'$desc','$createDate',$user_id,'$createDate',$user_id);";
					//On this insert sql statement i am not specifying the fields since i will update all of them
					//NULL is the totaltypeid, $desc if the descrition, $createDate  no problem
					$updateStm=$DB_con->prepare($sql); $updateStm->execute(); 
				}
				else if($action=='search')
				{
					/*Output Result Page */
					$option=$_GET['soption'];
					$val=$_GET['searchVal'];
					if($val=="")
					{
						$sql="Select * from Totals_Type;"; 
					}
					else
					{
						$sql="Select * from Totals_Type Where $option='$val';"; 
					}
					$querystmt=$DB_con->prepare($sql); 
					$querystmt->execute(); 			
					while($row=$querystmt->fetchObject()) 
					{ 
						echo "&ensp;<b><a href='totalTypes.php?viewdetails={$row->TotalTypeID}'>{$row->TotalTypeID} {$row->TotalTypeName}</a></b></li>";
						echo "<br/>";
					}							
				}
			}
			
			/* Output Result Page */
			$sql="Select * from Totals_Type;";
			$querystmt=$DB_con->prepare($sql);
			$querystmt->execute();
			
				while($row=$querystmt->fetchObject()) 
				{
					if ($action != 'search')
					{
						echo "&ensp;<b><a href='totalTypes.php?viewdetails={$row->TotalTypeID}'>{$row->TotalTypeID} {$row->TotalTypeName}</a></b></li>";
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
		<div id="title">
		<h1>&thinsp;Details</h1>
		<hr/>
		</div>
		<?php
		try 
		{ 
			if(isset($_GET[ 'viewdetails']))
			{ 
				$id=$_GET[ 'viewdetails'];
				$sql="Select * from Totals_Type Where TotalTypeID=$id" ;
				$querystmt=$DB_con->prepare($sql);
				$querystmt->execute(); 
				$row=$querystmt->fetchObject(); 
				echo "
				<form>
				&ensp;<label>Totalizer #: {$row->TotalTypeID}</label>
				<input type='hidden' name='totalid' value='{$row->TotalTypeID}' />
				<br/>
				&ensp;<label>Name: </label>
				<input type='text' name='totalDesc' value='{$row->TotalTypeName}' />
				<br/>
				&ensp;<label>Created on: {$row->CreatedOn}</label>
				<br/>
				&ensp;<label>Updated on: {$row->UpdateOn}</label>			
				<br/>
				</br>
				&emsp;<button type='submit' type='submit' name='submit' value='update'>Update</button>
				<button type='submit' type='submit' name='submit' value='delete'>Delete</button>
				<button type='button'>Cancel</button>
				</form>"; 
			}
			if(isset($_GET['submit']))
			{ 
				$action=$_GET['submit'];
				if($action=='new')
				{ 
					$date=date("m/d/Y"); 
					echo "
					<form>
					&ensp;<label>Name: </label>
					<input type='text' name='totalDesc' value='' />
					<br/>
					</br>
					&emsp;<button type='submit' type='submit' name='submit' value='insert'>Insert</button>
					</form>";
				}
			}
		}
		catch(PDOException $ex) 
		{ 
			$user->redirect('error.php',$ex->getMessage()); 
		} 
		?>
	</div>
	<?php $page_Content=ob_get_contents(); 
	ob_end_clean(); 
	$pagetitle="Totalizers" ;
	include( "master.php"); ?>
</body>

</html>
