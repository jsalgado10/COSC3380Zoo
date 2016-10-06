<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="default.css" type="text/css" />
    <style>
.button {
    background-color: #ff0000;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
</style>

</head>

<body>



    <?php include 'menuBar.php'; menuBar(basename(__FILE__)); ?>
    <?php ob_start(); require_once (__DIR__.'/scripts/config.php'); ?>

    <div class="container">

        <div id="login">
            <form action="#">
                <fieldset>
                    <legend>Login</legend>
                    Email:
                    <br>
                    <input type="text" name="userName" value="">
                    <br> Password:
                    <br>
                    <input type="text" name="password" value="">
                    <br>
                    <br>
                    <input type="submit" value="Submit">
                </fieldset>
            </form>

        </div>
        
        <h3>OR</h3>
        
        <div id="signUp">
            <a href="signUp.php" class="button">Sign Up</a>
        </div>

    </div>



</body>

</html>