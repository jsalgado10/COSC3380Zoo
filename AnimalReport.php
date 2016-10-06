<?php ob_start(); require_once (__DIR__. '/scripts/config.php'); ?>
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
	<div id="title">
		<h1>Animal Report</h1></div>
	<div id = "selector" type = "submit">
		<form align="center">
			<select name = "selector">
				<?php 
					if($_GET['selector'] == 'sex')
					echo "<option value = 'sex' selected = 'true'>Sex</option>";
					else
					echo "<option value = 'sex'>Sex</option>";
					
					if($_GET['selector'] == 'class')
					echo "<option value = 'class' selected = 'true'>Classification</option>";
					else
					echo "<option value = 'class'>Classification</option>";
					
					$sql="SELECT  `classificationName` FROM  `classification` ORDER BY  `classificationName` ASC ";
					$query=$DB_con->prepare($sql);
					$query->execute();
					while($row=$query->fetchObject()) {
						if($_GET['selector'] == $row->classificationName)
						echo "<option value = '{$row->classificationName}' selected = 'true'>$row->classificationName</option>";
						else
						echo "<option value = '{$row->classificationName}'>$row->classificationName</option>";
					}
					
				?>
			</select>
			
			<?php
				if($_GET['selector'] != 'sex' && $_GET['selector'] != 'class' && $_GET['selector'] != null)
				{
					echo "	<select name = 'sortbyselector'>";
				
						if($_GET['sortbyselector'] == 'animalName')
						echo "<option value = 'animalName' selected = 'true'>Name</option>";
						else
						echo "<option value = 'animalName'>Name</option>";
						
						if($_GET['sortbyselector'] == 'animalSpecies')
						echo "<option value = 'animalSpecies' selected = 'true'>Species</option>";
						else
						echo "<option value = 'animalSpecies'>Species</option>";
						
						if($_GET['sortbyselector'] == 'animalBirthDate')
						echo "<option value = 'animalBirthDate' selected = 'true'>Birthdate</option>";
						else
						echo "<option value = 'animalBirthDate'>Birthdate</option>";
						
						if($_GET['sortbyselector'] == 'animalArrivalDate')
						echo "<option value = 'animalArrivalDate' selected = 'true'>Arrival Date</option>";
						else
						echo "<option value = 'animalArrivalDate'>Arrival Date</option>";
						
						if($_GET['sortbyselector'] == 'animalSex')
						echo "<option value = 'animalSex' selected = 'true'>Sex</option>";
						else
						echo "<option value = 'animalSex'>Sex</option>";
				
				echo "</select> 
				<select name = 'orderbyselector'>";
					
						if($_GET['orderbyselector'] == 'ASC')
						echo "<option value = 'ASC' selected = 'true'>Ascending</option>";
						else
						echo "<option value = 'ASC'>Ascending</option>";
				
				
				
						if($_GET['orderbyselector'] == 'DESC')
						echo "<option value = 'DESC' selected = 'true'>Descending</option>";
						else
						echo "<option value = 'DESC'>Descending</option>";
						
					echo "</select> ";
				}
			?>
			
			
			<button type='submit' name='submit' value='selector'>Show</button>
		</form>
	</div>
		
		<div id = "report">
		<?php 

			if($_GET['selector'] == 'sex')
			{
				echo "
						<table align='center'>
			<tr>
				<th>Animal Sex</th>
				<th>Count</th>
			</tr>
			";
				
					$sql="SELECT animalSex, COUNT(*) as Count FROM animal GROUP BY animalSex ORDER BY Count DESC;";
					$query=$DB_con->prepare($sql);
					$query->execute();
					foreach( $query as $row) {
						echo "
						<tr>
							<th>{$row['animalSex']}</th>
							<th>{$row['Count']}</th>
						</tr>
						";
					}
					echo "
			<tr>
				<th>Total Animal</th> ";
					$sql="SELECT COUNT(*) as Count FROM animal;";
					$query=$DB_con->prepare($sql);
					$query->execute();
					$row=$query->fetchObject();
						echo "
							<th>{$row->Count}</th>
						
			</tr>
			
		</table>
				";
			}
			if($_GET['selector'] == 'class')
			{
				echo "
				
				<table align='center'>
			<tr>
				<th>Classification</th>
				<th>Count</th>
			</tr>";
				
					$sql="SELECT classificationName, classificationSum FROM classification ORDER BY classificationSum DESC;";
					$query=$DB_con->prepare($sql);
					$query->execute();
					foreach( $query as $row) {
						echo "
						<tr>
							<th>{$row['classificationName']}</th>
							<th>{$row['classificationSum']}</th>
						</tr>
						";
					}
					echo "
			<tr>
				<th>Total Animal</th>";
				
					$sql="SELECT COUNT(*) as Count FROM animal;";
					$query=$DB_con->prepare($sql);
					$query->execute();
					$row=$query->fetchObject();
						echo "
							<th>{$row->Count}</th>
						
			</tr>
			
		</table>";
			}
			
			if($_GET['selector'] != 'class' && $_GET['selector'] != 'sex' && $_GET['selector'] != null)
			{
				
				$classname = $_GET['selector'];
				echo "
				
				<table align='center'>
				<tr>
					<th>Name</th>
					<th>Species</th>
					<th>Birthdate</th>
					<th>Arrival Date</th>
					<th>Sex</th>
				</tr>";
					
					
						
						$sortby = $_GET['sortbyselector'];
						$orderby = $_GET['orderbyselector'];
						if($sortby == null)
						{
							$sortby = 'animalName';
						}
						if($orderby == null)
						{
							$orderby = 'ASC';
						}
						$sql="SELECT `animalName`, `animalSpecies`,`animalBirthDate`,`animalArrivalDate`,`animalSex` FROM animal, classification Where animalClassificationID = classificationID and classificationName = '$classname' ORDER BY `$sortby` $orderby;";
						$query=$DB_con->prepare($sql);
						$query->execute();
						foreach( $query as $row) {
							echo "
							<tr>
								<th>{$row['animalName']}</th>
								<th>{$row['animalSpecies']}</th>
								<th>{$row['animalBirthDate']}</th>
								<th>{$row['animalArrivalDate']}</th>
								<th>{$row['animalSex']}</th>
							</tr>
							";
						}
						echo "
				
				</table>";
				
			}
			
			
			
			
		?>
		</div>

	<?php $page_Content=ob_get_contents(); ob_end_clean(); $pagetitle="Animal" ; include( "master.php"); ?>
	
	
</body>

</html>
