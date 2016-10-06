<?php
ob_start();
require_once (__DIR__.'/scripts/config.php');
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="site.css">
		<style>      

		</style>
	</head>
	<body>
		<div id = "title"><h1>Customers</h1></div>
			<div id = "search">
				<?php $user->fillDropDown('customer'); ?>
				
				<form action="customer.php">
    			<button type="submit">Customer Home</button>
				</form>


				</div>
			<div id="records">
			<h1>Results</h1>
			<hr/>
			<?php
			try
			{
			/* Update */
			if(isset($_GET['submit'])){
				$action=$_GET['submit'];
				
				if($action=='update'){
				$user_id = $_SESSION['user_session'];

				
				$cID = $_GET['cID'];
				$address = $_GET['address'];
				$city = $_GET['city'];
				$state = $_GET['state'];
				$zip = $_GET['zip'];
				$lName = $_GET['lName'];
				$fName = $_GET['fName'];
				$phone = $_GET['phone'];
				$email = $_GET['email'];
				$password = $_GET['password_1'];
				$memID = $_GET['mID'];
				$memExp = $_GET['ex'];;
			
				$deletedBy = $user_id;

				$sql="UPDATE customer SET customerAddress='$address', customerCity='$city', customerState='$state', customerZipCode='$zip', customerLastName='$lName', customerFirstName='$fName', customerPhoneNumber='$phone', customerEmail='$email', customerPassword='$password', MembershipExp='$memExp' WHERE customerID=$cID";
				
				$updateStm=$DB_con->prepare($sql);
				$updateStm->execute();
				}
				else if($action=='delete'){
					$cID = $_GET['cID'];
					$address = $_GET['address'];
					$city = $_GET['city'];
					$state = $_GET['state'];
					$zip = $_GET['zip'];
					$lName = $_GET['lName'];
					$fName = $_GET['fName'];
					$phone = $_GET['phone'];
					$email = $_GET['email'];
					$memID = $_GET['memID'];
					$memExp = $_GET['ex'];
				    $deletedOn = date("Y-m-d h:i:s");
					$deletedBy = $user_id;
					$userTypeID = 1;
					
					//copy old table details into the delete table
					$sql="INSERT INTO customer_del VALUES('$cID', '$address', '$city', '$state', '$zip' , '$lName' , '$fName' , '$phone' , '$email' , '$memID', '$deletedBy', '$deletedOn', '$userTypeID');";
					$updateStm=$DB_con->prepare($sql);
					$updateStm->execute();
					
					//Deleting Record from Table
					$sql="Delete from customer where customerID = $cID";
					$updateStm=$DB_con->prepare($sql);
					$updateStm->execute();
				}
				else if($action=='insert'){$user_id = $_SESSION['user_session'];
					//attributes to be added via sql query
					$cID = NULL;
					$address = $_GET['address'];
					$city = $_GET['city'];
					$state = $_GET['state'];
					$zip = $_GET['zip'];
					$lName = $_GET['lName'];
					$fName = $_GET['fName'];
					$phone = $_GET['phone'];
					$email = $_GET['email'];
					$password = $_GET['password_1'];
					$memID = $_GET['memID'];
					$memExp = $_GET['ex'];
					$createOn = date("Y-m-d h:i:s");
					$createdBy = $user_id;
					$lastUpdated = $createOn;
					$updatedBy = $user_id;
					$userTypeId = 1;
					
					$sql = "INSERT INTO customer VALUES('$cID', '$address', '$city', '$state', '$zip' , '$lName' , '$fName' , '$phone' , '$email' , '$password', '$memID', '$memExp', '$createOn', '$createdBy', '$lastUpdated', '$updatedBy', '$userTypeId');";
					
					$updateStm=$DB_con->prepare($sql);
					$updateStm->execute();
				}
				else if($action=='search')
				{
					/*Output Result Page */
					$option=$_GET['soption'];
					$val=$_GET['searchVal'];
					if($val=="")
					{
						$sql="SELECT * FROM customer;";
					}
					else
					{
						$sql="SELECT * FROM customer WHERE $option='$val';";
					}
					$querystmt=$DB_con->prepare($sql);
								$querystmt->execute();
					while($row=$querystmt->fetchObject())
					{
						echo "<b><a href='customer.php?viewdetails={$row->customerID}'> {$row->customerID} {$row->customerFirstName}  {$row->customerLastName}</a></b></li>";
						echo "<br/>";
					}						
				}
			}


			
			/*Output Result Page */
			$sql="Select * from customer;";
			$querystmt=$DB_con->prepare($sql);
			$querystmt->execute();
			
				while($row=$querystmt->fetchObject()) 
				{
					if ($action != 'search')
					{
						echo "<b><a href='customer.php?viewdetails={$row->customerID}'> {$row->customerID} {$row->customerFirstName}  {$row->customerLastName}</a></b></li>";
						echo "<br/>";
					}
				}
			}
			catch(PDOException $ex)
			{
				$user->redirect('error.php',$ex->getMessage());
			}
			?>
			<form>
				<button type='submit' type='submit' name='submit' value='new'>Add New</button>
			</form>
		</div>
	<div id="details">
			<h1>Details</h1>
			<hr/>
		<?php 
		try
		{
		if(isset($_GET['viewdetails'])){
			$id=$_GET['viewdetails'];
			$sql="Select * from customer Where customerID=$id";
			$querystmt=$DB_con->prepare($sql);
			$querystmt->execute();
			$row=$querystmt->fetchObject();
			$date=date("m/d/Y");
			
						echo "
						
						<form>
								<label>Customer ID: {$row->customerID}</label>
								<input type='hidden' name='cID' value='{$row->customerID}' />
								<br/>
								
								<label>First Name: </label>
								<input type='text' name='fName' value='{$row->customerFirstName}' />
								<br/>
								
								<label>Last Name: </label>
								<input type='text' name='lName' value='{$row->customerLastName}' />
								<br/>
								
								<label>Address: </label>
								<input type='text' name='address' value='{$row->customerAddress}' />
								<br/>
								
								<label>City: </label>
								<input type='text' name='city' value='{$row->customerCity}' />
								<br/>
								
								<label>State: </label>
								<input type='text' name='state' value='{$row->customerState}' />
								<br/>
								
								<label>Zip Code: </label>
								<input type='text' name='zip' value='{$row->customerZipCode}' />
								<br/>
								
								<label>Phone Number: </label>
								<input type='text' name='phone' value='{$row->customerPhoneNumber}' />
								<br/>
								
								<label>Email: </label>
								<input type='text' name='email' value='{$row->customerEmail}' />
								<br/>
								
								<label>Password: </label>
								<input type='text' name='password_1' value='{$row->customerPassword}' />
								<br/>
								
								<label>Membership ID: </label>
								<input type='text' name='memID' value='{$row->MembershipID}' />
								<br/>
								
								<label>Memebership Expiration: </label>
								<input type='text' name='ex' value='{$row->MembershipExp}' />
								<br/>
						
								
								
								<label>Created on: {$row->customerCreatedOn}</label>
								<br/>
								<label>Updated on: {$row->customerLastUpdated}</label>
								<br/>
								
								<button type='submit' type='submit' name='submit' value='update'>Update</button>
								<button type='submit' type='submit' name='submit' value='delete'>Delete</button>
								<button type='submit' type='submit' name='submit' value='cancel'>Cancel</button>
						</form>";
		}
		if(isset($_GET['submit'])){
			$action=$_GET['submit'];
			if($action=='new'){
			$date=date("m/d/Y");
			echo "<form>
			
			<label>First Name: </label>
			<input type='text' name='fName' value=''/>
			<br/>
			<label>Last Name: </label>
			<input type='text' name='lName' value=''/>
			<br/>
			<label>Address: </label>
			<input type='text' name='address' value=''/>
			<br/>
			<label>City: </label>
			<input type='text' name='city' value=''/>
			<br/>
			<label>State: </label>
			<input type='text' name='state' value=''/>
			<br/>
			<label>Zip Code: </label>
			<input type='text' name='zip' value=''/>
			<br/>
			<label>Phone Number: </label>
			<input type='text' name='phone' value=''/>
			<br/>
			<label>Email: </label>
			<input type='text' name='email' value=''/>
			<br/>
			<label>Password: </label>
			<input type='password' name='password_1' value=''/>
			<br/>
			<label>Retype Password: </label>
			<input type='password' name='password_2' value=''/>
			<br/>
			
			
			<label>Membership Type: </label>
			<br>
			<input type='radio' name='memID' value=100> Bronze<br>
			<input type='radio' name='memID' value=102> Silver<br>
			<input type='radio' name='memID' value=103> Gold<br>
			
			
			<label>Membership Expiration: </label>
			<input type='date' name='ex' value=''/>
			<br/>
			
			
			<button type='submit' type='submit' name='submit' value='insert'>Insert</button>
			</form>";
			}
		}
		
		}
		catch(PDOException $ex)
		{
			$user->redirect('error.php');
		}
		?>

	</div>
	<?php
	$page_Content=ob_get_contents();
	ob_end_clean();
	$pagetitle="Customers";
	include("master.php");
	?>
	</body>
</html>

