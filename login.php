<?php ob_start(); require_once (__DIR__. '/scripts/config.php'); if($user->isLoggedin()!="") { $user->redirect('index.php'); } if(isset($_POST['btn-login'])) { $uname = $_POST['txt_uname_email']; $upass = $_POST['txt_password']; if($user->login($uname,$upass)) { $user->redirect('index.php'); } else { $error = "Username or Password
are invalid!"; } } ?>



<!DOCTYPE html>
<html>

<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>Login : cleartuts</title>

 <link rel="stylesheet" href="./css/default.css" type="text/css" />
</head>

<body>
 <div class="container">
  <div class="form-container">
   <form id="login" method="post">
    <h2>&thinsp;Sign in</h2>
    <hr />
    <?php if(isset($error)) { ?>
    <div class="alert alert-danger">
     <i></i> &nbsp;
     <?php echo $error; ?>
    </div>
    <?php } ?>
    <div class="form-group">
     &ensp;<input type="text" name="txt_uname_email" placeholder="Username or E mail ID" required />
    </div>
    <div class="form-group">
     &ensp;<input type="password" name="txt_password" placeholder="Your Password" required />
    </div>
    <div class="clearfix"></div>
    <hr />
    <div class="form-group">
     &ensp;<button type="submit" name="btn-login">SIGN IN
     </button>
    </div>
   </form>
   
   </br></br></br>
   
   <?php
    echo "&thinsp; New? Register today!";
    echo "</br>";
   ?>
    
   <h2 style="color:red;">Sign up for a zoo membership.</h2>
   <h3>Benefits of creating a zoo membership are discounts on future purchases.</h3>

&emsp;<button><a href="register.php">Click here to register!</a></button>
 </br></br></br>



   






  </div>
 </div>
  <?php $page_Content=ob_get_contents(); ob_end_clean(); $pagetitle="Login" ; include( "master.php"); ?>
 </div>

</body>

</html>