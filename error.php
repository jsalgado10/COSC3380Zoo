<?php
ob_start();
require_once (__DIR__.'/scripts/config.php');
if(!$user->isLoggedin())
{
 $user->redirect('index.php');
}
$user_id = $_SESSION['user_session'];
$result = $DB_con->prepare("SELECT customerEmail as UserName FROM customer WHERE customerID=:user_id union select staffEmail as UserName from Staff where staffID=:user_id");
$result->execute(array(":user_id"=>$user_id));
$userRow=$result->fetchObject();
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="site.css">
		<style>      

		</style>
	</head>
	<body>
		<h1>Error Processing Request</h1>
		<?php
		echo $_GET['error'];
		?>
	<?php
	$page_Content=ob_get_contents();
	ob_end_clean();
	$pagetitle="Error Page";
	include("master.php");
	?>
	</body>
</html>