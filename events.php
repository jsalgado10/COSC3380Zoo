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
		<h1>Events</h1>
		<div id="calendar">
					<iframe src="https://calendar.google.com/calendar/embed?height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=m7qh7dkup0ivaquo2mmi0d7jns%40group.calendar.google.com&amp;color=%232F6309&amp;ctz=America%2FChicago" style="border-width:0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
					
				</div>
		</div>
		<?php
	$page_Content=ob_get_contents();
	ob_end_clean();
	$pagetitle="Events";
	include("master.php");
	?>
	</body>
</html>
