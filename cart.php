<?php
// include page header html
include 'layout.php';

use Src\helper\Path;
use Src\models\Product;
use Src\models\ProductImage;
use Src\models\CartItem;
use Src\models\Users;

$product = new Product;
$cart_item = new CartItem;
$path = new Path;

// set page title
$page_title = "Cart";

$action = $_GET['action'] ?? "";

echo "<div class='col-md-12'>";
if ($action == 'removed') {
    echo "<div class='alert alert-info'>
             Product was removed from your cart!
                 </div>";
} else if ($action == 'quantity_updated') {
    echo "<div class='alert alert-info'>
            Product quantity was updated!
                </div>";
} else if ($action == 'exists') {
    echo "<div class='alert alert-info'>
            Product already exists in your cart!
                </div>";
} else if ($action == 'cart_emptied') {
    echo "<div class='alert alert-info'>
               Cart was emptied.
                </div>";
} else if ($action == 'updated') {
    echo "<div class='alert alert-info'>
            Quantity was updated.
                </div>";
} else if ($action == 'unable_to_update') {
    echo "<div class='alert alert-danger'>
            Unable to update quantity.
                </div>";
}
echo "</div>";


// $cart_count variable is initialized in navigation.php
if ($cart_item->count_all() > 0) {
    $cartItem = $cart_item->getProductCart();
    $total = 0;
    $item_count = 0;

    foreach ($cartItem as $cart) {
        $sub_total = $cart->subtotal;

        echo "<div class='cart-row'>
                <div class='col-md-8'>
                    <div class='product-name m-b-10px'>
                        <h4>{$cart->name}</h4>
                  </div>";

        // update quantity
        echo "<form class='update-quantity-form' method='POST' action='update_quantity.php?id={$cart->id}'>
                   <div class='input-group'>
                        <input type='number' name='Cart[quantity]' value='{$cart->quantity}' class='form-control cart-quantity' min='1' />
                        <input type='hidden' name='Cart[user_id]' value='{$cart->user_id}' >
                         <input type='hidden' name='Cart[product_id]' value='{$cart->product_id}' >
                            <span class='input-group-btn'>
                                <button class='btn btn-default update-quantity' type='submit'>Update</button>
                                    </span>
                                        </div>
                </form>";

        // delete from cart
        echo "<a href='remove_from_cart.php?id={$cart->id}' class='btn btn-default'>
                Delete
                    </a>
                    </div>";

        echo "<div class='col-md-4'>
                    <h4>$" . number_format($cart->quantity * $cart->price, 2, '.', ',') . "</h4>";
        echo "</div>
                </div>";

        $item_count += $cart->quantity;
        $total += $sub_total;
    }

    echo "<div class='col-md-8'></div>";
    echo "<div class='col-md-4'>";
    echo "<div class='cart-row'>";
    echo "<h4 class='m-b-10px'>Total ({$item_count} items)</h4>";
    echo "<h4>$" . number_format($total, 2, '.', ',') . "</h4>";
    echo "<form method='POST' action='checkout.php'>";
    echo "<button type='submit' class='btn btn-success m-b-10px'>";
    echo "<span class='glyphicon glyphicon-shopping-cart'></span> Proceed to Checkout";
    echo "</button>";
    echo "</form>";
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