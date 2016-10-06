<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="default.css" type="text/css" />
    
</head>

<body>


<?php include 'menuBar.php'; menuBar(basename(__FILE__)); ?>
        
<?php ob_start(); require_once (__DIR__.'/scripts/config.php'); ?>

<?php 

    $isValidForm = true;
    
    if(isset($_POST['firstName'])){
        //echo '<br>' . $_POST['firstName'];
    }
    else
    {
        $isValidForm = false;
        echo 'you did not enter a first name';
    }
    if(isset($_POST['lastName'])){
        //echo '<br>' . $_POST['lastName'];
    }
    else
    {
        $isValidForm = false;
        echo 'you did not enter a last name';
    }
    if(isset($_POST['userName'])){
        //echo '<br>' . $_POST['userName'];
    }
    else
    {
        $isValidForm = false;
        echo 'you did not enter a userName';
    }
    if(isset($_POST['password1'])){
        if(isset($_POST['password2'])){
            $var1 = $_POST['password1'];
            $var2 = $_POST['password2'];
            
            if (strcmp ($var1 , $var2) != 0){
                $isValidForm = false;
            }
            else{
                //echo 'your passwords DO match!';
            }
            
        }
        else{
                echo 'you did not enter a matching password';
            }
        
        //echo '<br>' . $_POST['password1'];
    }
    else
    {
        $isValidForm = false;
        echo 'you did not enter a password';
    }
    
    //if everything was entered correctly we add a new customer
    if($isValidForm == true){
        
        $ID = NULL;
        $userName = $_POST['userName'];; 
        $password = $_POST['password1'];
        $fName = $_POST['firstName'];
        $lName = $_POST['lastName'];
        $createdOn = date('y,m,d');
        $status = 0; // all customer are 0, admins are 1. admins only created on database.
        
        $sql = "INSERT INTO account VALUES('$ID', '$userName', '$password', '$fName', '$lName', '$createdOn', '$status');";
        
        $updateStm=$DB_con->prepare($sql);
		$updateStm->execute();
		
		echo "customer created!";
    
    }
    
?>

</body>

</html>

