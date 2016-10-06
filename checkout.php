<?php
ob_start();
require_once (__DIR__.'/scripts/config.php');
$totalSale=$_SESSION['total'];
?>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Check Out</title>
        <link rel="stylesheet" href="css/checkout.css">
  </head>

  <body>

        <div id=payment>
  <form method="post" action="complete.php">
    <div class="form-container">
      <div class="personal-information">
          <?php
        echo '<h1>$'.$totalSale.'</h1>';
        ?>
        <h1>Payment Information</h1>
      </div> 
      <input id="input-field" type="text" name="streetaddress" required="required" autocomplete="on" maxlength="45" placeholder="Street Address"/>

      <input id="column-left" type="text" name="city" required="required" autocomplete="on" maxlength="20" placeholder="City"/>

      <input id="column-right" type="text" name="zipcode" required="required" autocomplete="on" pattern="[0-9]*" maxlength="5" placeholder="ZIP code"/>
      
      <input id="input-field" type="email" name="email" required="required" autocomplete="on" maxlength="40" placeholder="  E-mail"/>
    
      <input id="column-left" type="text" name="first-name" placeholder="First Name"/>
      
      <input id="column-right" type="text" name="last-name" placeholder="Surname"/>
      
      <input id="input-field" type="text" name="number" placeholder="Card Number"/>
     
      <input id="column-left" type="text" name="expiry" placeholder="MM / YY"/>
        
      <input id="column-right" type="text" name="cvc" placeholder="CCV"/>
      <input type="hidden" name="type" value="complete" />
      <input id="input-button" type="submit" value="Submit"/>
    </form>
    </div>
  </div> <!-- end of form-container -->
</body>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/121761/card.js'></script>
<script src='https://s3-us-west-2.amazonaws.com/s.cdpn.io/121761/jquery.card.js'></script>

        
        	<?php $page_Content=ob_get_contents(); 
	ob_end_clean(); 
	$pagetitle="Check out" ;
	include( "master.php"); ?>
</html>
