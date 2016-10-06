<?php
ob_start();
require_once (__DIR__.'/scripts/config.php');
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="./css/cart.css">
        <link rel="stylesheet" type="text/css" href="./css/index_style.css">
    </head>
    <body>
        <div id="content">
            <h1>Product List</h1>
            <div class="products">
    
<?php
$current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

$sql="Select * from item i join itemType it on i.itemTypeID=it.itemTypeID";
$qrystmt = $DB_con->prepare($sql);
$qrystmt->execute();
if($qrystmt){ 
$products_item = '<ul class="products">';
//fetch results set as object and output HTML
while($obj = $qrystmt->fetchObject())
{
$products_item .= <<<EOT
    <li class="product">
    <form method="post" action="cart_update.php">
    <div class="product-content"><h3>{$obj->itemTypeName}</h3>
    
    <div class="product-desc">{$obj->itemDescription}</div>
    <div class="product-info">
    Price $ {$obj->itemPrice}
    
    <fieldset>
    
    <label>
        <span>Quantity</span>
        <input type="text" size="2" maxlength="2" name="product_qty" value="1" />
    </label>
    
    </fieldset>
    <input type="hidden" name="product_code" value="{$obj->itemID}" />
    <input type="hidden" name="type" value="add" />
    <input type="hidden" name="return_url" value="{$current_url}" />
    <div align="center"><button type="submit" class="add_to_cart">Add</button></div>
    </div></div>
    </form>
    </li>
EOT;
}
$products_item .= '</ul>';
echo $products_item;
}
?>
</div>
</div>
	<?php $page_Content=ob_get_contents(); 
	ob_end_clean(); 
	$pagetitle="Item List" ;
	include( "master.php"); ?>
	</body>
</html>