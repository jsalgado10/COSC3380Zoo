<?php if(!$user->isLoggedin()) 
{ 
    $role=0;
}
else
{
    $role=1;
}
$user_id = $_SESSION['user_session']; 
$result = $DB_con->prepare("SELECT customerEmail as UserName FROM customer WHERE customerID=:user_id union select staffEmail as UserName from Staff where staffID=:user_id");
$result->execute(array(":user_id"=>$user_id)); $userRow=$result->fetchObject(); ?>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="./css/default.css">
    <title>
        <?php echo $pagetitle;?>
    </title>
</head>

<body>
    <div id="wrapper">
        <div style="background-color:white; padding: 5px;" id="title">
            
            <a href="index.php" id="logo"><img src="images/houston_zoo_edit_2.PNG" alt=""/></a>

            <h5 style="line-height: 0.02; color: red">Open from 6 a.m - 7 p.m on weekdays</h5>
        </div>

        <?php $user->showMenu($role);?>
        <?php echo $page_Content; ?>

        <div id="footer">
            <p>Copyright &copy; 2016 COSC 3380 - Team 9</p>
        </div>
    </div>


</body>

</html>