<?php

// include page header html
include 'index.php';

use Src\helper\Notification;
use Src\models\Checkout;
use Src\models\product;
use Src\models\Users;
use Src\helper\Error;

// set page title
$page_title = "Checkout";


// initialize objects
$checkout = new Checkout;
$products = new Product;
$user = new Users;
$error = new Error();

// var_dump($cartItem);
$cart_count = $cartItem->countCartItems();
// var_dump($cart_count);

// $cart_count variable is initialized in navigation.php
if ($cart_count > 0) {

    // $cart_item->user_id="1";
    $stmt = $cartItem->find_all();
    $total = 0;
    $item_count = 0;

    foreach ($stmt as $cart) {

        $product = $products->find_by_id($cart->product_id);
        // echo $stmt;
        // $product =  ;
        $sub_total = $product->price * $cart->quantity;

        echo "<div class='cart-row'>";
        echo "<div class='col-md-8'>";
        echo "<div class='product-name m-b-10px'><h4>{$product->name}</h4></div>";
        echo $cart->quantity > 1 ? "<div>{$cart->quantity} items</div>" : "<div>{$cart->quantity} item</div>";

        echo "</div>";

        echo "<div class='col-md-4'>";
        echo "<h4>$" . number_format($product->price, 2, '.', ',') . "</h4>";
        echo "</div>";
        echo "</div>";

        $item_count += $cart->quantity;
        $total += $sub_total;
    }


    echo "<div class='col-md-12 text-align-center'>";
    echo "<div class='cart-row'>";
    if ($item_count > 1) {
        echo "<h4 class='m-b-10px'>Total ({$item_count} items)</h4>";
    } else {
        echo "<h4 class='m-b-10px'>Total ({$item_count} item)</h4>";
    }
    echo "<h4>$<span id='result'>" . number_format($total, 2, '.', ',') . "</span></h4>";
    echo "<form method='POST' action='place_order.php'> 
  <input type='hidden' name='Checkout[sub_total]' value='{$total}'>
  <input type='hidden' name='Checkout[product_id]' value='{$product->id}'>
  <input type='hidden' name='Checkout[user_id]' value='1'>
  <input type='hidden' name='Checkout[order_id]' value='1'>
  <input type='hidden' name='Checkout[quantity]' value='1'>
  
    <label for='delivery'>Pickup</label>
  <input type='radio' id='pickup' name ='Checkout[delivery_type]' value='pickup'>
  
  <label for='delivery'>Delivery($5 USD)</label>
  <input type='radio' id='delivery' name ='Checkout[delivery_type]' value='delivery'>
  
  ";
    echo "<button type='submit'  class='btn btn-lg btn-success m-b-10px'>";

    echo "<span class='glyphicon glyphicon-shopping-cart'></span> Place Order";
    echo "</button>";
    echo "</form>";

    echo "<script>

let result = document.querySelector('#result');
        document.body.addEventListener('change', function (e) {
            let target = e.target;
            let message;
                
               if (target.id == 'pickup'){
                   message = $total
               }else if (target.id == 'delivery'){
                   message = ($total+5)
               }
            result.textContent = message;
        });
</script>";
    echo "</div>";
    echo "</div>";

} else {
    echo "<div class='col-md-12'>";
    echo "<div class='alert alert-danger'>";
    echo "No products found in your cart!";
    echo "</div>";
    echo "</div>";
}

?>