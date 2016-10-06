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
		<div id = "title"><h1>Animal</h1></div>
			<div id = "search">
				<?php $user->fillDropDown('animal'); ?>
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
			
			$nameErr = $classErr = $bdErr = $adErr = $sexErr = $speciesErr= "";
			
			try
			{
				
				
			/* Update */
			if(isset($_GET['submit'])){
				$action=$_GET['submit'];
				
				if($action=='update'){
				$user_id = $_SESSION['user_session'];
				$id=$_GET['animalid'];
				$name=$_GET['animalname'];
				$classid=$_GET['animalclassid'];
				$species = $_GET['animalspecies'];
				$birthdate=$_GET['animalbirthdate'];
				$arrivaldate=$_GET['animalarrivaldate'];
				$sex=$_GET['animalsex'];
				$url = $_GET['animalurl'];
				

				
				if (empty($name)) {
					     $nameErr = 'You can\'t leave Name empty.';
					   } else {
					     $name = test_input($name);
					     if (!preg_match('/^[a-zA-Z ]*$/',$name)) {
					       $nameErr = 'Only letters and white space allowed.'; 
					       
					     }
					   }
					   
					   if (empty($species)) {
					     $speciesErr = 'You can\'t leave Species empty.';
					   } else {
					     $species = test_input($species);
					     if (!preg_match('/^[a-zA-Z ]*$/',$species)) {
					       $speciesErr = 'Only letters and white space allowed.'; 
					       
					     }
					   }
					   
					   if (empty($birthdate)) {
					     $bdErr = 'You can\'t leave Birth Date empty.';
					   } else {
					     $birthdate = test_input($birthdate);
						if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',$birthdate)) {
					       $bdErr = 'Invalid Birth Date.'; 
						}
					   }
					   
					   if (empty($arrivaldate)) {
					     $adErr = 'You can\'t leave Arrival Date empty.';
					   } else {
					     $arrivaldate = test_input($arrivaldate);
						if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',$arrivaldate)) {
					       $adErr = 'Invalid Arrival Date.'; 
						}else
						{
							if(strlen($bdErr)==0 && strtotime($birthdate)>strtotime($arrivaldate))
							{
								$adErr = 'Arrival Date cannot be before Birth Date.'; 
							}
						}
					   }
					   
					   if (empty($url)) {
					     $urlErr = 'You can\'t leave Picture URL empty.';
					   } else {
					     $url = test_input($url);
					   }
				
				if(strlen($nameErr)==0 && strlen($classErr)==0 && strlen($speciesErr)==0 && strlen($bdErr)==0 && strlen($adErr)==0 && strlen($sexErr)==0  && strlen($urlErr)==0)
					{
						$sql="update animal set animalName='$name',animalClassificationID='$classid',animalSpecies = '$species' ,animalBirthDate='$birthdate', animalArrivalDate = '$arrivaldate', animalSex = '$sex', animalPictureURL = '$url' where animalID=$id;";
						$updateStm=$DB_con->prepare($sql);
						$updateStm->execute();
					}
				}
				else if($action=='delete'){
					$user_id = $_SESSION['user_session'];
					$id=$_GET['animalid'];
					$name=$_GET['animalname'];
					$classid=$_GET['animalclassid'];
					$species = $_GET['animalspecies'];
					$birthdate=$_GET['animalbirthdate'];
					$arrivaldate=$_GET['animalarrivaldate'];
					$sex=$_GET['animalsex'];
					$url = $_GET['animalurl'];
					$deleteDate=date("Y-m-d h:i:s");
					if (empty($name)) {
					     $nameErr = 'You can\'t leave Name empty.';
					   } else {
					     $name = test_input($name);
					     if (!preg_match('/^[a-zA-Z ]*$/',$name)) {
					       $nameErr = 'Only letters and white space allowed.'; 
					       
					     }
					   }
					   
					   if (empty($species)) {
					     $speciesErr = 'You can\'t leave Species empty.';
					   } else {
					     $species = test_input($species);
					     if (!preg_match('/^[a-zA-Z ]*$/',$species)) {
					       $speciesErr = 'Only letters and white space allowed.'; 
					       
					     }
					   }
					   
					   if (empty($birthdate)) {
					     $bdErr = 'You can\'t leave Birth Date empty.';
					   } else {
					     $birthdate = test_input($birthdate);
						if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',$birthdate)) {
					       $bdErr = 'Invalid Birth Date.'; 
						}
					   }
					   
					   if (empty($arrivaldate)) {
					     $adErr = 'You can\'t leave Arrival Date empty.';
					   } else {
					     $arrivaldate = test_input($arrivaldate);
						if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',$arrivaldate)) {
					       $adErr = 'Invalid Arrival Date.'; 
						}else
						{
							if(strlen($bdErr)==0 && strtotime($birthdate)>strtotime($arrivaldate))
							{
								$adErr = 'Arrival Date cannot be before Birth Date.'; 
							}
						}
					   }
					   
					   if (empty($url)) {
					     $urlErr = 'You can\'t leave Picture URL empty.';
					   } else {
					     $url = test_input($url);
					   }
				
				if(strlen($nameErr)==0 && strlen($classErr)==0 && strlen($speciesErr)==0 && strlen($bdErr)==0 && strlen($adErr)==0 && strlen($sexErr)==0 && strlen($urlErr)==0)
					{
					//Copying Record to Delete Table
					$sql="INSERT INTO `animal_Del` (`animalID`, `animalName`,`animalClassificationID`,`animalSpecies`, `animalBirthDate`, `animalArrivalDate`, `animalSex`,`animalPictureURL` , `animalDeletedOn`, `animalDeletedBy`) VALUES ($id,'$name',$classid,'$species','$birthdate','$arrivaldate','$sex','$url','$deleteDate',$user_id);";
					$updateStm=$DB_con->prepare($sql);
					$updateStm->execute();
					
					//Deleting Record from Table
					$sql="Delete from animal where animalID = $id";
					$updateStm=$DB_con->prepare($sql);
					$updateStm->execute();
					}
				}
				else if($action=='insert'){
					$user_id = $_SESSION['user_session'];
					$name=$_GET['animalname'];
					$classid=$_GET['animalclassid'];
					$species = $_GET['animalspecies'];
					$birthdate=$_GET['animalbirthdate'];
					$arrivaldate=$_GET['animalarrivaldate'];
					$sex=$_GET['animalsex'];
					$url = $_GET['animalurl'];
					$createDate=date("Y-m-d h:i:s");
					
					if (empty($name)) {
					     $nameErr = 'You can\'t leave Name empty.';
					   } else {
					     $name = test_input($name);
					     if (!preg_match('/^[a-zA-Z ]*$/',$name)) {
					       $nameErr = 'Only letters and white space allowed.'; 
					       
					     }
					   }
					   
					   if (empty($species)) {
					     $speciesErr = 'You can\'t leave Species empty.';
					   } else {
					     $species = test_input($species);
					     if (!preg_match('/^[a-zA-Z ]*$/',$species)) {
					       $speciesErr = 'Only letters and white space allowed.'; 
					       
					     }
					   }
					   
					   if (empty($birthdate)) {
					     $bdErr = 'You can\'t leave Birth Date empty.';
					   } else {
					     $birthdate = test_input($birthdate);
						if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',$birthdate)) {
					       $bdErr = 'Invalid Birth Date.'; 
						}
					   }
					   
					   if (empty($arrivaldate)) {
					     $adErr = 'You can\'t leave Arrival Date empty.';
					   } else {
					     $arrivaldate = test_input($arrivaldate);
						if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/',$arrivaldate)) {
					       $adErr = 'Invalid Arrival Date.'; 
						}else
						{
							if(strlen($bdErr)==0 && strtotime($birthdate)>strtotime($arrivaldate))
							{
								$adErr = 'Arrival Date cannot be before Birth Date.'; 
							}
						}
					   }
					   if (empty($url)) {
					     $urlErr = 'You can\'t leave Picture URL empty.';
					   } else {
					     $url = test_input($url);
					   }
					   
					   
					
					if(strlen($nameErr)==0 && strlen($classErr)==0 && strlen($speciesErr)==0 && strlen($bdErr)==0 && strlen($adErr)==0 && strlen($sexErr)==0 && strlen($urlErr)==0)
					{
					$sql="Insert into animal VALUES(NULL,'$name', $classid, '$species','$birthdate','$arrivaldate','$sex','$url','$createDate',$user_id,'$createDate',$user_id);";
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
						$sql="Select * from animal;"; 
					}
					else
					{
						$sql="Select * from animal Where $option='$val';"; 
					}
					$querystmt=$DB_con->prepare($sql); 
					$querystmt->execute(); 			
					while($row=$querystmt->fetchObject()) 
					{ 
						echo "&ensp;<b><a href='Animal.php?viewdetails={$row->animalID}'>{$row->animalID} {$row->animalName}</a></b></li>";
						echo "<br/>";
					}							
				}
			}


			
			/*Output Result Page */
			$sql="Select * from animal;";
			$querystmt=$DB_con->prepare($sql);
			$querystmt->execute();
			
				while($row=$querystmt->fetchObject()) 
				{
					if ($action != 'search')
					{
						echo "&ensp;<b><a href='Animal.php?viewdetails={$row->animalID}'>{$row->animalID} {$row->animalName}</a></b></li>";
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
			$sql="Select * from animal Where animalID=$id";
			$querystmt=$DB_con->prepare($sql);
			$querystmt->execute();
			$row=$querystmt->fetchObject();
			
			
			$bd = date("Y-m-d",strtotime($row->animalBirthDate));
			$ad = date("Y-m-d",strtotime($row->animalArrivalDate));
			$co = date("m/d/Y h:i:s",strtotime($row->animalCreatedOn));
			$uo = date("m/d/Y h:i:s",strtotime($row->animalUpdatedOn));
			$date = date("m/d/Y h:i:s");
			
			$classvalue = $row->animalClassificationID;
			$sexvalue = $row->animalSex;
			$speciesvalue = $row->animalSpecies;
			$urlvalue = $row->animalPictureURL;
			echo "<form>
			<img src='$urlvalue' alt=''style='width:100px;height:100px;'/>
			<br/>
			<input type='hidden' name='animalid' value='{$row->animalID}'/>
			&ensp;<label>Name: </label>
			<input type='text' name='animalname' value='{$row->animalName}' maxlength='20'/>
			<span style='color:red'>* $nameErr</span>
			<br/>
			&ensp;<label>Classification: </label>
			<select name = 'animalclassid'>";
			
			$sql='SELECT  `classificationID` ,  `classificationName` FROM classification';
	        $queryclass=$DB_con->prepare($sql);
	        $queryclass->execute();
	        while($row=$queryclass->fetchObject()) {
	            if($classvalue==$row->classificationID)
	            echo "<option value = '$row->classificationID' selected = 'true'>$row->classificationName</option>";

				else echo "<option value = '$row->classificationID'>$row->classificationName</option>";
	        }
	        
	        echo "
	    	</select>
	    	<span style='color:red'>* $classErr</span>
			<br/>
			&ensp;<label>Species: </label>
			<input type='text' name='animalspecies' value='$speciesvalue' maxlength='20'/>
			<span style='color:red'>* $speciesErr</span>
			<br/>
			
			
			&ensp;<label>Birth Date: </label>
			<input type='date' name='animalbirthdate' value='$bd'/>
			<span style='color:red'>* $bdErr</span>
			<br/>
			&ensp;<label>Arrival Date: </label>
			<input type='date' name='animalarrivaldate' value='$ad'/>
			<span style='color:red'>* $adErr</span>
			<br/>
			&ensp;<label>Sex: </label>
			<select name = 'animalsex'>";
			
			
			if($sexvalue=='M')
			{
				echo "<option value = 'M' selected = 'true'>Male</option>";
			echo "<option value = 'F'>Female</option>";
			}
			else
			{
				echo "<option value = 'M' >Male</option>";
			echo "<option value = 'F' selected = 'true'>Female</option>";
			}
			
			echo"
			</select>
			<span style='color:red'>* $sexErr</span>
			<br/>
			&ensp;<label>Picture URL: </label>
			<input type='text' name='animalurl' value='$urlvalue'/>
			<span style='color:red'>* $urlErr</span>
			<br/>
			&ensp;<label>Created on: $co</label>
			<br/>
			&ensp;<label>Updated on: $uo</label>
			<br/>
			&ensp;<label>Current Date: $date </label>
			<br/>
			<br/>
			&emsp;<button name='submit' value='update'>Update</button>
			<button name='submit' value='delete'>Delete</button>
			<button type='submit' name='submit' value='cancel'>Cancel</button>
			</form>";
			
			
		}
		if(isset($_GET['submit'])){
			$action=$_GET['submit'];
			if($action=='new' || $action == 'insert' && !(strlen($nameErr)==0 && strlen($classErr)==0 && strlen($speciesErr)==0 && strlen($bdErr)==0 && strlen($adErr)==0 && strlen($sexErr)==0 && strlen($urlErr)==0)){
			$date=date("m/d/Y");
			
			
			echo "<form>
			&ensp;<label>Name: </label>
			<input type='text' name='animalname' value='$name' maxlength='20'/>
			<span style='color:red'>* $nameErr</span>
			<br/>
			&ensp;<label>Classification: </label>
			
			<select name = 'animalclassid'>";
			
			$sql='SELECT  `classificationID` ,  `classificationName` FROM classification';
	        $queryclass=$DB_con->prepare($sql);
	        $queryclass->execute();
	        while($row=$queryclass->fetchObject()) {
	            
	            echo "<option value = '$row->classificationID'>$row->classificationName</option>";
	        }
	        
	        echo "
	    	</select>
			<span style='color:red'>* $classErr</span>
			<br/>
			&ensp;<label>Species: </label>
			<input type='text' name='animalspecies' value='$species' maxlength='20'/>
			<span style='color:red'>* $speciesErr</span>
			<br/>
			
			&ensp;<label>Birth Date: </label>
			<input type='date' name='animalbirthdate' value='$birthdate'/>
			<span style='color:red'>* $bdErr</span>
			<br/>
			&ensp;<label>Arrival Date: </label>
			<input type='date' name='animalarrivaldate' value='$arrivaldate'/>
			<span style='color:red'>* $adErr</span>
			<br/>

			&ensp;<label>Sex: </label>
			<select name = 'animalsex'>";
			
			
			if($sexvalue=='F')
			{
				echo "<option value = 'M' >Male</option>";
			echo "<option value = 'F' selected = 'true'>Female</option>";
			}
			else
			{
				echo "<option value = 'M' selected = 'true'>Male</option>";
			echo "<option value = 'F' >Female</option>";
			}
			
			echo"</select>
			<span style='color:red'>* $sexErr</span>
			<br/>
			&ensp;<label>Picture URL: </label>
			<input type='text' name='animalurl' value='$url'/>
			<span style='color:red'>* $urlErr</span>
			<br/>
			&emsp;<button type='submit' name='submit' value='insert'>Insert</button>
			</form>";
			}
			if($action=='update' )
			{
				$sql="Select * from animal Where animalID=$id";
			$querystmt=$DB_con->prepare($sql);
			$querystmt->execute();
			$row=$querystmt->fetchObject();
			
			
			$bd = date("Y-m-d",strtotime($row->animalBirthDate));
			$ad = date("Y-m-d",strtotime($row->animalArrivalDate));
			$co = date("m/d/Y h:i:s",strtotime($row->animalCreatedOn));
			$uo = date("m/d/Y h:i:s",strtotime($row->animalUpdatedOn));
			$date = date("m/d/Y h:i:s");
			$classvalue = $row->animalClassificationID;
			$sexvalue = $row->animalSex;
			$speciesvalue = $row->animalSpecies;
			$urlvalue = $row->animalPictureURL;
			echo "<form>
			<img src='$urlvalue' alt=''style='width:100px;height:100px;'/>
			<br/>
			<input type='hidden' name='animalid' value='{$row->animalID}'/>
			&ensp;<label>Name: </label>
			<input type='text' name='animalname' value='{$row->animalName}' maxlength='20'/>
			<span style='color:red'>* $nameErr</span>
			<br/>
			&ensp;<label>Classification: </label>
			<select name = 'animalclassid'>";
			
			$sql='SELECT  `classificationID` ,  `classificationName` FROM classification';
	        $queryclass=$DB_con->prepare($sql);
	        $queryclass->execute();
	        while($row=$queryclass->fetchObject()) {
	            if($classvalue==$row->classificationID)
	            echo "<option value = '$row->classificationID' selected = 'true'>$row->classificationName</option>";

				else echo "<option value = '$row->classificationID'>$row->classificationName</option>";
	        }
	        
	        echo "
	    	</select>
	    	<span style='color:red'>* $classErr</span>
			<br/>
			&ensp;<label>Species: </label>
			<input type='text' name='animalspecies' value='$speciesvalue' maxlength='20'/>
			<span style='color:red'>* $speciesErr</span>
			<br/>
			&ensp;<label>Birth Date: </label>
			<input type='date' name='animalbirthdate' value='$bd'/>
			<span style='color:red'>* $bdErr</span>
			<br/>
			&ensp;<label>Arrival Date: </label>
			<input type='date' name='animalarrivaldate' value='$ad'/>
			<span style='color:red'>* $adErr</span>
			<br/>
			&ensp;<label>Sex: </label>
			<select name = 'animalsex'>";
			
			
			if($sexvalue=='M')
			{
				echo "<option value = 'M' selected = 'true'>Male</option>";
			echo "<option value = 'F'>Female</option>";
			}
			else
			{
				echo "<option value = 'M' >Male</option>";
			echo "<option value = 'F' selected = 'true'>Female</option>";
			}
			
			echo"
			</select>
			<span style='color:red'>* $sexErr</span>
			<br/>
			&ensp;<label>Picture URL: </label>
			<input type='text' name='animalurl' value='$urlvalue'/>
			<span style='color:red'>* $urlErr</span>
			<br/>
			&ensp;<label>Created on: $co</label>
			<br/>
			&ensp;<label>Updated on: $uo</label>
			<br/>
			&ensp;<label>Current Date: $date </label>
			<br/>
			<br/>
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
	$pagetitle="Animal";
	include("master.php");
	?>
	</body>
</html>

