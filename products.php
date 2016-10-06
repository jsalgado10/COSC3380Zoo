<?php
ob_start();
require_once (__DIR__.'/scripts/config.php');
$sql="Select * from item i join itemType it on i.itemTypeID=it.itemTypeID";
$qrystmt = $DB_con->prepare($sql);
$qrystmt->execute();
if ($qrystmt) { 
	while($obj = $qrystmt->fetchObject()){
?>
<html>
    <head>
<link rel="stylesheet" type="text/css" href="./css/products.css">
    </head>	
<body>
<div class="product-item">
	<form method="post" action="index.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
	<div class="product-image"><img src="<?php echo $product_array[$key]["image"]; ?>"></div>
	<div><strong><?php echo $product_array[$key]["name"]; ?></strong></div>
	<div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
	<div><input type="text" name="quantity" value="1" size="2" /><input type="submit" value="Add to cart" class="btnAddAction" /></div>
	</form>
</div>
<?php }} ?>

	<?php $page_Content=ob_get_contents(); 
	ob_end_clean(); 
	$pagetitle="Item List" ;
	include( "master.php"); ?>
	</body>
</html>