<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="default.css" type="text/css" />
    
</head>

<body>



    <?php include 'menuBar.php'; menuBar(basename(__FILE__)); ?>
    <?php ob_start(); require_once (__DIR__.'/scripts/config.php'); ?>


    <div class="container">

        <div id="signUp">
            <form action="processingPage.php" method="post">
                <fieldset>
                    <legend>Sign Up</legend>
                    First Name:
                    <br>
                    <input type="text" name="firstName" value="John">
                    <br> 
                    Last Name:
                    <br>
                    <input type="text" name="lastName" value="Smith">
                    <br>
                    User Name:
                    <br>
                    <input type="text" name="userName" value="">
                    <br>
                    Password:
                    <br>
                    <input type="password" name="password1" value="123">
                    <br>
                    Retype Password:
                    <br>
                    <input type="password" name="password2" value="123">
                    <br>
                    
                    <input type="submit" value="Submit";">
                </fieldset>
            </form>

        </div>
        
        
       

    </div>



</body>

</html>