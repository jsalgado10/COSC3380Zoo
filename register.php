<?php
ob_start();
require_once (__DIR__.'/scripts/config.php');
?>
<html>
    <head>
        <link rel="stylesheet" href="./css/default.css" type="text/css" />
    </head>
    <body>
        
        <div id="content">
            
            
        
        <h1>&thinsp;Registration</h1>
        <hr>
        
        
        <form method="post" action="processCustomerRegistration.php">

</br>
    &ensp;<label>First Name: </label>
    <input type='text' name='fName' value='' />
    <br/>
    &ensp;<label>Last Name: </label>
    <input type='text' name='lName' value='' />
    <br/>
    </br>
    &ensp;<label>Address: </label>
    &ensp;<input type='text' name='address' value='' />
    <br/>
    &ensp;<label>City: </label>
    <input type='text' name='city' value='' />
    <br/>
    &ensp;<label>State: </label>
    <input type='text' name='state' value='' />
    <br/>
    &ensp;<label>Zip Code: </label>
    <input type='text' name='zip' value='' />
    <br/>
    </br>
    &ensp;<label>Phone Number: </label>
    <input type='text' name='phone' value='' />
    <br/>
    &ensp;<label>Email: </label>
    <input type='text' name='email' value='' />
    <br/>
    </br>
    &ensp;<label>Password: </label>
    <input type='password' name='password_1' value='' />
    <br/>
    
    &ensp;<label>Retype Password: </label>
    <input type='password' name='password_2' value='' />
    <br/>
    </br>
    &ensp;<label>Membership Type: </label>
			<br>
			<input type='radio' name='memID' value=100> Bronze - $5<br>
			<input type='radio' name='memID' value=102> Silver - $10<br>
			<input type='radio' name='memID' value=103> Gold - $15<br>
			
			
    </br>
    &emsp;<input type="submit" value="Submit">
    </br></br><hr></br></br>

   </form>
   
   
   </div>

<?php
	$page_Content=ob_get_contents();
	ob_end_clean();
	$pagetitle="Customers";
	include("master.php");
	?>


    </body>
</html>



