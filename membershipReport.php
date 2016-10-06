<?php
ob_start();
require_once (__DIR__.'/scripts/config.php');
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="site.css">
		<style>
		table, th, td {
		    border: 2px solid black;
		    border-collapse: collapse;
		}
		th, td {
		    padding: 5px;
		    text-align: left;    
		}
		</style>
	</head>
	<body>
		<div id = "title"><h1>Membership Report</h1></div>
	
			<hr/></br>
			
			<table align="center" style="width:50%">
			    <tr>
			        <th>Membership Type</th>
			        <th>Percent Discount</th>
			        <th>Count</th>
			    </tr>
			
		    	<?php
			        $sql=	
			        	"SELECT m.membershipName, m.memberDiscount, COUNT(c.MembershipID) as Count
			        	FROM membership m INNER JOIN customer c
			        	ON m.membershipID=c.MembershipID
						GROUP BY m.membershipName
						ORDER BY m.memberDiscount ASC";
			        
		        	$query=$DB_con->prepare($sql);
		        	$query->execute();
		    			
		        	foreach($query as $row)
		        	{
	    	    	 	echo "<tr>
	        		 	    <th>{$row['membershipName']}</th>
	        		 	    <td>{$row['memberDiscount']}</td>
	        		 	    <td>{$row['Count']}</td>
	        		 	</tr>";
	        		}
		    	?>
		    </table>
		    
	</br></br></br>
	    
    	<?php
        	$page_Content=ob_get_contents();
        	ob_end_clean();
        	$pagetitle="membership";
        	include("master.php");
    	?>
	</body>
	
</html>