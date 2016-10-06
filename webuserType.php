<?php
	ob_start();
	require_once (__DIR__.'/scripts/config.php');

	$img_url='http://www.animatedgif.net/underconstruction/5consbar2_e0.gif';
?>

<img src="<?php echo $img_url;?>">

<?php
	echo "<h1>This page is still under construction. Please try again later.</h1>";
	echo "<h2>Sorry! We'll be done soon. Thank you for your patience.</h2>";
?>

<img src="<?php echo $img_url;?>">

<?php
	$page_Content=ob_get_contents();
	ob_end_clean();
	$pagetitle="WebUserType";
	include("master.php");
?>