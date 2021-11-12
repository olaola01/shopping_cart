<?php
include 'layout.php';

// include objects
use Src\models\Product;
use Src\models\ProductImage;
use Src\models\CartItem;

// initialize objects
$productImage = new ProductImage;
$cart_item = new CartItem;

// to prevent undefined index notice
$action = $_GET['action'] ?? "";

// for pagination purposes
$current_page = $_GET['page'] ?? 1; // page is the current page, if there's nothing set, default is page 1
$product = new Product;
$total_count = $product->count_all();


// read all products in the database
$products = $product->find_all();
$cartItem = $cart_item->find_all();

// if products retrieved were more than zero
if ($total_count > 0) {
    // needed for paging
    $page_url = "products.php?";
    $total_rows = $total_count;

// set page title
    $page_title = "Products";
    include_once "read_products_template.php";
} else // tell the user if there's no products in the database
{
    echo "<div class='col-md-12'>
              <div class='alert alert-danger'>No products found.</div>
                </div>";
}
