<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="menuBar.css" type="text/css" />
    

</head>
<body>

<?php
function menuBar($page) {

     echo '<ul>';
     if($page == 'home.php'){
        echo '<li><a class="active" href="home.php">Home</a></li>';
   
     }
     else{ 
      echo '<li><a href="home.php">Home</a></li>';
     }
     
     if($page == 'giftShop.php'){
        echo '<li><a class="active" href="giftShop.php">Gift Shop</a></li>';
   
     }
     else{ 
      echo '<li><a href="giftShop.php">Gift Shop</a></li>';
     }
     
     if($page == 'about.php'){
        echo '<li><a class="active" href="about.php">About</a></li>';
   
     }
     else{ 
      echo '<li><a href="about.php">About</a></li>';
     }
     
     if($page == 'login.php'){
        echo '<li style="float:right"><a class="active" href="login.php">Login</a></li>';
   
     }
     else{ 
      echo '<li style="float:right"><a href="login.php">Login</a></li>';
     }
 
          
echo '</ul>';
     

}
?>
</body>
</html>
