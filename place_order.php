<?php


include_once 'layout.php';

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
$users  = new Users;
$path = new Path;
$notification = new Notification;
$cart_items = $cart_item->find_all();
$user = $users->find_by_id(1);

if ($path->is_post_request()) {

    $args = $_POST['Checkout'];



    if (isset($args['delivery_type']) && $args['delivery_type'] === 'delivery') {

        $args['sub_total'] ;
        $args['total'] = $args['sub_total'] + 5;

        $args['delivery_type'] = 1;
        $total = (int)$args['total'];
        if ($total < $user->balance){

            $checkout->merge_attributes($args);
            $result = $checkout->create();

            $notification->message("Your order has been placed!, Thank you very much!");
            echo $notification->display_success_message();

            $user->previous_balance = $user->balance;

            $user->balance -= (int)$args['total'];

            $user->created = date("Y-m-d H:i:s");
            $user->modified = date("Y-m-d H:i:s");
            $users->update(1);

            foreach ($cart_items as $cart) {
                $cart_item->delete($cart->id);
            }
        }
        else{
            $notification->message("Your account balance is low");
            echo $notification->display_danger_message();
        }

    } else if (isset($args['delivery_type']) && $args['delivery_type'] === 'pickup')
    {
        $args['sub_total'];
        $args['total'] = $args['sub_total'];
        $args['delivery_type'] = 0;
        $total = (int)$args['total'];

        if ($total < $user->balance)
        {
            $user->previous_balance = $user->balance;
            $user->balance -= $args['total'];
            $checkout->merge_attributes($args);
            $result = $checkout->create();
            $users->update(1);

            $notification->message("Your order has been placed!, Thank you very much!");
            echo $notification->display_success_message();

            foreach ($cart_items as $cart) {
                $cart_item->delete($cart->id);
            }
        }
        else{
            $notification->message("Your account balance is low!");
            echo $notification->display_danger_message();

        }

        # code...
    } else if (!isset($args['delivery_type'])) {
        $notification->message('You need to select a delivery option, go back to cart please');
        echo $notification->display_danger_message();

    }
}