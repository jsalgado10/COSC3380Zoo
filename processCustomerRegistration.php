<?php ob_start(); require_once (__DIR__.'/scripts/config.php'); ?>
<html>

    <head>
        <link rel="stylesheet" href="./css/default.css" type="text/css" />
    
    </head>

    <body>

            


        
<div id="content">

<?php 


    $isValidForm = true;
    
    if(isset($_POST['fName'])){
        //echo '<br>' . $_POST['firstName'];
    }
    else
    {
        $isValidForm = false;
        echo 'you did not enter a first name';
        echo '<br>';
    }
    if(isset($_POST['lName'])){
        //echo '<br>' . $_POST['lastName'];
    }
    else
    {
        $isValidForm = false;
        echo 'you did not enter a last name';
        echo '<br>';
    }
    if(isset($_POST['address'])){
        //echo '<br>' . $_POST['userName'];
    }
    else
    {
        $isValidForm = false;
        echo 'you did not enter a address';
        echo '<br>';
    }
    if(isset($_POST['city'])){
        //echo '<br>' . $_POST['userName'];
    }
    else
    {
        $isValidForm = false;
        echo 'you did not enter a city';
        echo '<br>';
    }
    if(isset($_POST['state'])){
        //echo '<br>' . $_POST['userName'];
    }
    else
    {
        $isValidForm = false;
        echo 'you did not enter a state';
    }
    if(isset($_POST['zip'])){
        //echo '<br>' . $_POST['userName'];
    }
    else
    {
        $isValidForm = false;
        echo 'you did not enter a zip';
        echo '<br>';
    }
    if(isset($_POST['phone'])){
        //echo '<br>' . $_POST['userName'];
    }
    else
    {
        $isValidForm = false;
        echo 'you did not enter a phone';
        echo '<br>';
    }
    if(isset($_POST['email'])){
        //echo '<br>' . $_POST['userName'];
    }
    else
    {
        $isValidForm = false;
        echo 'you did not enter a email';
        echo '<br>';
    }
    
    
    
    if(isset($_POST['password_1'])){
        if(isset($_POST['password_2'])){
            $var1 = $_POST['password_1'];
            $var2 = $_POST['password_2'];
            
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
        
                    $cID = NULL;
					$memExp = date("2020-m-d h:i:s");
					$createOn = date("Y-m-d h:i:s");
					$createdBy = $user_id;
					$lastUpdated = $createOn;
					$updatedBy = $user_id;
					$userTypeId = 1;
					
				    $address = $_POST['address'];
    				$city = $_POST['city'];
    				$state = $_POST['state'];
    				$zip = $_POST['zip'];
    				$lName = $_POST['lName'];
    				$fName = $_POST['fName'];
    				$phone = $_POST['phone'];
    				$email =$_POST['email'];
    				$password = $_POST['password_1'];
    				$memID = $_POST['memID'];
				    
					
					$sql = "INSERT INTO customer VALUES('$cID', '$address', '$city', '$state', '$zip' , '$lName' , '$fName' , '$phone' , '$email' , '$password', '$memID', '$memExp', '$createOn', NULL, '$lastUpdated', NULL, '$userTypeId');";
					
					
					$updateStm=$DB_con->prepare($sql);
					$updateStm->execute();
					
					echo "Customer Created";
					
					
					
    
    }
    
?>

<br>
<br>
<br>
<br>
<br>
</div>

    <?php
	$page_Content=ob_get_contents();
	ob_end_clean();
	$pagetitle="ProcessCustomer";
	include("master.php");
	?>

    </body>

</html>

