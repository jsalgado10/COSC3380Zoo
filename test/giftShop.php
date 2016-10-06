<!DOCTYPE html>
<html>

<head>

  <link rel="stylesheet" href="default.css" type="text/css" />

</head>

<body>







  <?php ob_start(); require_once (__DIR__. '/scripts/config.php'); ?>
  <?php include 'menuBar.php'; menuBar(basename(__FILE__)); ?>


  <div id="container">
    

    <div id="content">
      <div id="nav">
        <h3>Select a report</h3>

        <select>
          <option value="a_to_z">A to Z</option>
          <option value="low_to_high">Price: Low to High</option>
          <option value="high_to_low">Price: High to Low</option>
        </select>



      </div>

      <div id="main">
        <style>
          table,
          th,
          td {
            border: 1px solid black;
          }
        </style>
        </head>

        <body>

          <table>
            <tr>
              <th>Item</th>
              <th>Price</th>
            </tr>
            <tr>
              <td>January</td>
              <td>$100</td>
            </tr>
            <tr>
              <td>February</td>
              <td>$80</td>
            </tr>
          </table>

          <?php 
          //$query="SELECT * FROM item";
          //$result=mysql_query($query);
            
				
					$sql="SELECT item, COUNT(*) as Count FROM item GROUP BY animalSex ORDER BY Count DESC;";
					$query=$DB_con->prepare($sql);
					$query->execute();
					foreach( $query as $row) {
						echo "
						<tr>
							<th>{$row['animalSex']}</th>
							<th>{$row['Count']}</th>
						</tr>
						";
					}
				
          ?>
            
      </div>

    </div>
  </div>




  </body>

</html>