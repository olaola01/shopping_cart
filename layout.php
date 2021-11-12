<?php
include "vendor/autoload.php";
include "src/initialize.php";

use Src\models\Users;
use Src\models\CartItem;

$user = new Users;
$cartItem = new CartItem;
$readUser = $user->find_by_id(1);
$userBalance = $readUser->balance;


?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo isset($page_title) ? $page_title : "Shopping App"; ?></title>

    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>

    <!-- custom css for users -->
    <link href="styles/styles.css" rel="stylesheet" media="screen">

</head>

<body>
<!-- navbar -->
<nav>
    <div class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="container">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="products.php">Shopping App</a>
            </div>

            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">

                    <!-- highlight if $page_title has 'Products' word. -->
                    <!--                        TODO: Look for what page title is-->
                    <li>
                        <a href="products.php">Products</a>
                    </li>

                    <li>
                        <a href="cart.php">

                            Cart <span class="badge"
                                       id="comparison-count cart-container"><?php echo $cartItem->countCartItems() ?></span>
                        </a>
                    </li>

                    <!-- User Balance -->
                    <li>
                        <a href="cart.php">
                            <?php echo $userBalance ?>
                        </a>
                    </li>
                </ul>

            </div>
            <!--/.nav-collapse -->

        </div>
    </div>
    <!-- /navbar -->
</nav>
<!-- container -->
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="page-header">
                <h1><?php echo $page_title ?? "Shopping Cart App"; ?></h1>
            </div>
        </div>


    </div>
    <!-- /row -->

</div>
<!-- /container -->

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- custom script will be here -->
<script>
    $(document).ready(function () {
        var cartCount = <?php echo $cartItem->countCartItems(); ?>

            $(".product-form").submit(function (e) {
                console.log(cartCount)
                var form_data = $(this).serialize();
                console.log(form_data);
                var button_content = $(this).find('button[type=submit]');

                button_content.html('Adding...');
                $.ajax({
                    url: "add_to_cart.php",
                    type: "POST",
                    data: form_data
                }).done(function (data) {
                    cartCount++;
                    console.log(cartCount);
                    $('.badge').html(cartCount);
                    $("#cart-container").html(cartCount);
                    button_content.html(
                        "<a href = 'cart.php' class = 'btn btn-success w-100-pct' > Update Cart  </a> "
                    );
                })
                e.preventDefault();
            });
        console.log(cartCount)


    //     $(".product-form").submit(function (e) {
    //         $.ajax({
    //             url: "place_order.php",
    //             type: "POST",
    //             data: {
    //                 user_id: $user_id,
    //                 order_id: $order_id,
    //                 sub_total: $subtotal,
    //                 total: $total,
    //                 delivery: $delivery,
    //                 quantity: $quantity,
    //
    //
    //         });
    //     })
    //
    // });


    })

</script>
</body>

</html>