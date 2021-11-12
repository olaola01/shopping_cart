<?php
include "vendor/autoload.php";
include "src/initialize.php";

use Src\helper\StringUtils;
use Src\models\CartItem;
use Src\helper\Path;

$cart_item = new CartItem;
$date = new StringUtils;
$path = new Path;

// parameters
$product_id = $_POST['id'] ?? "";
$quantity = $_POST['quantity'] ?? 1;

$quantity = $quantity <= 0 ? 1 : $quantity;

// set cart item values
$cart_item->user_id = 1; // we default to '1' because we do not have logged in user
$cart_item->product_id = $product_id;
$cart_item->quantity = $quantity;
$cart_item->created = $date->format_date();

//$result =

// check if the item is in the cart, if it is, do not add
if ($cart_item->exists($product_id) > 0) {
    // redirect to product list and tell the user it was added to cart
    $path->redirect_to("cart.php?action=exists");
} // else, add the item to cart
else {
    $result = $cart_item->create();

    if ($result) {
        $path->redirect_to("product.php?id={$product_id}&action=added");
    } else {
        $path->redirect_to("product.php?id={$product_id}&action=unable_to_add");
    }
}