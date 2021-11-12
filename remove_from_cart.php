<?php
include "vendor/autoload.php";
include "src/initialize.php";

use Src\helper\Path;
use Src\models\CartItem;

$cart_item = new CartItem;
$path = new Path;


$product_id = $_GET['id'] ?? "";

$delete = $cart_item->delete($product_id);

if($delete)
{
    $path->redirect_to('cart.php?action=removed&id=' . $product_id);

}

