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
			<div id="zoo">
				<h1>Welcome to the Zoo</h1>
				<p>The Houston Zoo is made up of many moving parts. We have over 6,000 permanent residents (our animals) for whom we provide housing, meals, medical care and, yes, even education! There are over 2 million guests each year who come to experience our incredible variety of animals and ecosystems, as well as attend special private and public events and entertainment. Our dedicated staff works around the clock to ensure that the Zoo is always running smoothly for the safety and well being of our residents and guests.</p>
			</div>
		</div>
	<div id="content">
				<div id="featured">
					<h2>Meet our Animals</h2>
					<ul>
						<li class="first">
							<a href="gallery.php"><img src="images/animals/button-view-gallery.jpg" alt=""/></a>
							<a href="gallery.php">Gallery</a>
						</li>
					</ul>
				</div>
				<?php
	$page_Content=ob_get_contents();
	ob_end_clean();
	$pagetitle="Home";
	include("master.php");
	?>
	
	</body>
</html>
