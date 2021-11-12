<?php
include "vendor/autoload.php";
include "src/initialize.php";

use Src\helper\Path;
use Src\models\CartItem;

$cart_item = new CartItem;
$path = new Path;

$cart_id = $_GET['id'] ?? "";

if($path->is_post_request())
{
    $args = $_POST['Cart'];
    $cart_item->merge_attributes($args);
    $result = $cart_item->update($cart_id);

    if ($result) {
        // redirect to product list and tell the user it was added to cart
        $path->redirect_to("cart.php?action=updated");
    } else {
        $path->redirect_to("cart.php?action=unable_to_update");
    }

}

