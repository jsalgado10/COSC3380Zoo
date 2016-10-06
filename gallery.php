<?php
ob_start();
require_once (__DIR__.'/scripts/config.php');
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/index_style.css">

	</head>
	<body>
		<div id="content">
			<h1>Meet Our Animals</h1>
					<table border="1">
					<?php
					
							echo "<tr>";
						
							$sql="SELECT `animalName`, `animalPictureURL` FROM animal ORDER BY animal.animalArrivalDate DESC LIMIT 0 , 5;";
							$query=$DB_con->prepare($sql);
							$query->execute();
							foreach( $query as $row) {
							echo "
							<th>
							<figure >
							  <img src='{$row['animalPictureURL']}' alt=''style='width:100px;height:100px;'/>
							  <figcaption> {$row['animalName']} </figcaption>
							</figure>
							</th>
							";
							}
							
							echo "</tr>";
							
							echo "<tr>";
							
							$sql="SELECT `animalName`, `animalPictureURL` FROM animal ORDER BY animal.animalArrivalDate DESC LIMIT 5 , 10;";
							$query=$DB_con->prepare($sql);
							$query->execute();
							foreach( $query as $row) {
							echo "
							<th>
							<figure >
							  <img src='{$row['animalPictureURL']}' alt=''style='width:100px;height:100px;'/>
							  <figcaption> {$row['animalName']} </figcaption>
							</figure>
							</th>
							";
							}
							
							echo "</tr>";
							
							
							echo "<tr>";
							
							$sql="SELECT `animalName`, `animalPictureURL` FROM animal ORDER BY animal.animalArrivalDate DESC LIMIT 10 , 15;";
							$query=$DB_con->prepare($sql);
							$query->execute();
							foreach( $query as $row) {
							echo "
							<th>
							<figure >
							  <img src='{$row['animalPictureURL']}' alt=''style='width:100px;height:100px;'/>
							  <figcaption> {$row['animalName']} </figcaption>
							</figure>
							</th>
							";
							}
							
							echo "</tr>";
						?>
					
				</table>
				
	</div>
	
	
	<?php
	$page_Content=ob_get_contents();
	ob_end_clean();
	$pagetitle="Gallery";
	include("master.php");
	?>
	
	
	</body>
</html>
