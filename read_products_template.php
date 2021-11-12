<?php


foreach ($products as $product) {

    // creating box
    echo "<div class='col-md-4 m-b-20px'>";

    // product id for javascript access
    echo "<div class='product-id  display-none' style='display:none;'>{$product->id}</div>";

    echo "<a href='product.php?id={$product->id}' class='product-link'>";
    // select and show first product image
    $getProductimage = $productImage->find_product_image_by_id($product->id);
    echo "<div class='m-b-10px'>
               <img src='src/uploads/images/{$getProductimage->name}' class='w-100-pct' />
            </div>";

    // product name
    echo "<div class='product-name m-b-10px'>{$product->name}</div>
            </a>";

    // product price and category name
    echo "<div class='m-b-10px'>
            $" . number_format($product->price, 2, '.', ',');
    echo "</div>";

    // add to cart button
    echo "<div class='m-b-10px'>";

    // if product was already added in the cart
    if ($cart_item->exists($product->id)) {
        echo "<a href='cart.php' class='btn btn-success w-100-pct'>
                        Update Cart
                            </a>";
    } else {
        echo " <form class='product-form' method='POST'>
                    <input type='hidden' id='id' name = 'id' value =$product->id >
                    <button  class='btn btn-primary w-100-pct' type='submit'>Add to Cart</button>
                     </form>";
    }
    echo "</div>
            </div>";
}
