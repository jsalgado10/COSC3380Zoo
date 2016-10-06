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
		<div id = "title"><h1>Classification</h1></div>
			<div id = "search">
		<?php $user->fillDropDown('classification'); ?>
				</div>
		<div id="records">
			<h1>&thinsp;Results</h1>
			<hr/>
			<?php
			
			function test_input($data) {
			   $data = trim($data);
			   $data = stripslashes($data);
			   $data = htmlspecialchars($data);
			   return $data;
			}
			
			$nameErr = $aboutErr = $sumErr = "";
			
			try
			{
			/* Update */
			if(isset($_GET['submit'])){
				$action=$_GET['submit'];
				
				if($action=='update'){
				$user_id = $_SESSION['user_session'];
				$id=$_GET['classid'];
				$name=$_GET['classname'];
				$about=$_GET['classabout'];
				$sum = $_GET['classsum'];
				
				
					if (empty($name)) {
				     $nameErr = 'You can\'t leave Name empty.';
				   } else {
				     $name = test_input($name);
				     if (!preg_match('/^[a-zA-Z ]*$/',$name)) {
				       $nameErr = 'Only letters and white space allowed.'; 
				       
				     } else {
				     	$sql="SELECT * FROM  `classification` WHERE  `classificationName` =  '$name' and `classificationID` != '$id'";
						$checknamesql=$DB_con->prepare($sql);
						$checknamesql->execute();
						$result = $checknamesql->fetchObject();
				     	if(!empty($result))
				     	{
				     		$nameErr = 'Name is not unique.'; 
				     	}
				     }
				   }
				   
				   if (empty($about)) {
				     $aboutErr = 'You can\'t leave About empty.';
				   } else {
				     $about = test_input($about);
				     if (!preg_match('/^[a-zA-Z ,.]*$/',$about)) {
				       $aboutErr = 'Only letters, white spaces, and ,. allowed.'; 
				       
				    }
				    
				   }
				     $sum = test_input($sum);
				     if (!preg_match('/^[0-9]*$/',$sum)) {
				       $sumErr = 'Only numbers allowed.'; 
				       
					}
				
				
				
					if(strlen($nameErr)==0 && strlen($aboutErr)==0 && strlen($sumErr) == 0)
					{
						$sql="update classification set classificationName='$name', classificationAbout = '$about' , classificationSum = $sum where classificationID=$id;";
						$updateStm=$DB_con->prepare($sql);
						$updateStm->execute();
					}
				}
				else if($action=='delete'){
					$user_id = $_SESSION['user_session'];
					$id=$_GET['classid'];
					$name=$_GET['classname'];
					$about=$_GET['classabout'];
					$sum = $_GET['classsum'];
					$deleteDate=date("Y-m-d h:i:s");
					
					//Copying Record to Delete Table
					$sql="INSERT INTO `classification_Del` (`classificationID`, `classificationName`, `classificationAbout`,`classificationSum`, `classificationDeletedOn`, `classificationDeletedBy`) VALUES ($id,'$name', '$about',$sum,'$deleteDate',$user_id);";
					$updateStm=$DB_con->prepare($sql);
					$updateStm->execute();
					
					//Deleting Record from Table
					$sql="Delete from classification where classificationID = $id";
					$updateStm=$DB_con->prepare($sql);
					$updateStm->execute();
				}
				else if($action=='insert'){
					$user_id = $_SESSION['user_session'];
					$name=$_GET['classname'];
					$about=$_GET['classabout'];
					$createDate=date("Y-m-d h:i:s");
					
					
					 if (empty($name)) {
					     $nameErr = 'You can\'t leave Name empty.';
					   } else {
					     $name = test_input($name);
					     if (!preg_match('/^[a-zA-Z ]*$/',$name)) {
					       $nameErr = 'Only letters and white space allowed.'; 
					       
					     } else {
					     	$sql="SELECT * FROM  `classification` WHERE  `classificationName` =  '$name' ";
							$checknamesql=$DB_con->prepare($sql);
							$checknamesql->execute();
							$result = $checknamesql->fetchObject();
					     	if(!empty($result))
					     	{
					     		$nameErr = 'Name is not unique.'; 
					     	}
					     }
					   }
					   
					   if (empty($about)) {
					     $aboutErr = 'You can\'t leave About empty.';
					   } else {
					     $about = test_input($about);
					     if (!preg_match('/^[a-zA-Z ,.]*$/',$about)) {
					       $aboutErr = 'Only letters, white spaces, commas, and ,. allowed.'; 
					       
					     }
					   }
					
					if(strlen($nameErr)==0 && strlen($aboutErr)==0)
					{
						$sql="Insert into classification VALUES(NULL,'$name', '$about', 0 ,'$createDate', $user_id,'$createDate',$user_id);";
						$updateStm=$DB_con->prepare($sql);
						$updateStm->execute();
					}
					
				}
				else if($action=='search')
				{
					$option=$_GET['soption'];
					$val=$_GET['searchVal'];
											
				}
			}
			
			

			
			/*Output Result Page */
			if($val=="")
					{
						$sql="Select * from classification;"; 
					}
					else
					{
						$sql="Select * from classification Where $option='$val';"; 
					}
					$querystmt=$DB_con->prepare($sql); 
					$querystmt->execute(); 			
					while($row=$querystmt->fetchObject()) 
					{ 
						echo "&ensp;<b><a href='Classification.php?viewdetails={$row->classificationID}'>{$row->classificationID} {$row->classificationName}</a></b></li>";
						echo "<br/>";
					}	
			}
			catch(PDOException $ex)
			{
				$user->redirect('error.php');
			}
			
			
			
			?>
			</br>
			<form>
				&emsp;<button type='submit' name='submit' value='new'>Add New</button>
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
			$sql="Select * from classification Where classificationID=$id";
			$querystmt=$DB_con->prepare($sql);
			$querystmt->execute();
			$row=$querystmt->fetchObject();
			$date=date("m/d/Y");
			echo "<form>
			<input type='hidden' name='classid' value='{$row->classificationID}'>
			&ensp;<label>Name: </label>
			<input type='text' name='classname' value='{$row->classificationName}' maxlength='20' >
			<span style='color:red'>* $nameErr</span>
			<br/>
			&ensp;<label for='textarea'>About: </label>
			<textarea name='classabout' rows='7' cols='50' style='vertical-align:top' maxlength='1000' >{$row->classificationAbout}</textarea>
			<br/>
			<span style='color:red'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp* $aboutErr</span>
			<br/>
			&ensp;<label>Sum: </label>
			<input type='text' name='classsum' value='{$row->classificationSum}' maxlength='5' >
			<span style='color:red'>* $sumErr</span>
			<br/>
			&ensp;<label>Created on: {$row->classificationCreatedOn}</label>
			<br/>
			&ensp;<label>Updated on: {$row->classificationUpdatedOn}</label>
			<br/>
			&ensp;<label>Current Date: $date </label>
			<br/>
			</br>
			&emsp;<button type='submit' name='submit' value='update'>Update</button>
			<button type='submit' name='submit' value='delete'>Delete</button>
			<button type='submit' name='submit' value='cancel'>Cancel</button>
			</form>";
			
		}
		if(isset($_GET['submit'])){
			$action=$_GET['submit'];
			if($action=='new' || $action == 'insert' && !(strlen($nameErr)==0 && strlen($aboutErr)==0 && strlen($sumErr) == 0)){
			$date=date("m/d/Y");
			echo "<form>
			&ensp;<label>Name: </label>
			<input type='text' name='classname' value='$name' maxlength='20'>
			<span style='color:red'>* $nameErr</span>
			<br/>
			&ensp;<label for='textarea'>About: </label>
			<textarea name='classabout' rows='7' cols='50' style='vertical-align:top' maxlength='1000'>$about</textarea>
			<br/>
			<span style='color:red'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp* $aboutErr</span>
			<br/>
			</br>
			&emsp;<button type='submit' name='submit' value='insert'>Insert</button>
			</form>";
			}
			
			if($action=='update' )
			{
				$sql="Select * from classification Where classificationID=$id";
				$querystmt=$DB_con->prepare($sql);
				$querystmt->execute();
				$row=$querystmt->fetchObject();
				$date=date("m/d/Y");
				echo "<form>
				<input type='hidden' name='classid' value='{$row->classificationID}'>
				&ensp;<label>Name: </label>
				<input type='text' name='classname' value='{$name} 'maxlength='20'>
				<span style='color:red'>* $nameErr</span>
				<br/>
				&ensp;<label for='textarea'>About: </label>
				<textarea name='classabout' rows='7' cols='50' style='vertical-align:top' maxlength='1000' >{$about}</textarea>
				<br/>
				<span style='color:red'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp* $aboutErr</span>
				<br/>
				&ensp;<label>Sum: </label>
				<input type='text' name='classsum' value='{$row->classificationSum}' maxlength='5' >
				<span style='color:red'>* $sumErr</span>
				<br/>
				&ensp;<label>Created on: {$row->classificationCreatedOn}</label>
				<br/>
				&ensp;<label>Updated on: {$row->classificationUpdatedOn}</label>
				<br/>
				&ensp;<label>Current Date: $date </label>
				<br/>
				</br>
				&emsp;<button type='submit' name='submit' value='update'>Update</button>
				<button type='submit' name='submit' value='delete'>Delete</button>
				<button type='submit' name='submit' value='cancel'>Cancel</button>
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
	$pagetitle="Classification";
	include("master.php");
	?>
	</body>
</html>

