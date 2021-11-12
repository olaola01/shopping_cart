<?php


include_once 'index.php';

use Src\helper\Notification;
use Src\helper\StringUtils;
use Src\helper\Path;
use Src\models\CartItem;
use Src\models\Product;
use Src\models\Checkout;
use Src\models\Users;

$page_title = "Thank You!";

$cart_item = new CartItem;
$product = new Product;
$checkout = new Checkout;
$user = new Users;
$path = new Path;
$notification = new Notification;
$cart_items = $cart_item->find_all();


if ($path->is_post_request()) {

    $args = $_POST['Checkout'];

    if (isset($args['delivery_type']) && $args['delivery_type'] === 'delivery') {

        $args['sub_total'] += 5;

        $checkout->merge_attributes($args);
        $result = $checkout->create();

        $notification->message("Your order has been placed!, Thank you very much!");
        echo $notification->display_success_message();

        foreach ($cart_items as $cart) {
            $cart_item->delete($cart->id);
        }

    } else if (!isset($args['delivery_type'])) {
        $notification->message('You need to select a delivery option, go back to cart please');
        echo $notification->display_danger_message();

    }
}