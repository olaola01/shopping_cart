<?php


// include page header HTML
include_once 'index.php';


// include classes
use Src\models\Ratings;
use Src\models\Product;
use Src\models\ProductImage;
use Src\models\CartItem;
use Src\helper\Path;


// initialize objects
$product = new Product();
$product_image = new ProductImage();
$cart_item = new CartItem();
$rating = new Ratings();

// get ID of the product to be edited and action
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
$action = isset($_GET['action']) ? $_GET['action'] : "";

// set the id as product id property
$product->id = $id;

// to read single record product
$product->find_by_id($id);

// set page title
$page_title = $product->name;

// get ID of the product to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
$action = isset($_GET['action']) ? $_GET['action'] : "";

// set the id as product id property
$product->id = $id;


// set page title
$page_title = $product->name;


echo "<div class='col-md-12'>";
if ($action == 'added') {
    echo "<div class='alert alert-info'>";
    echo "Product was added to your cart!";
    echo "</div>";
} else if ($action == 'unable_to_add') {
    echo "<div class='alert alert-info'>";
    echo "Unable to add product to cart. Please contact Admin.";
    echo "</div>";
}
echo "</div>";

// set product id
$product_image->product_id = $id;

// read all related product image
$stmt_product_image = $product_image->find_product_image_by_id($id);

// count all relatd product image
// $num_product_image = $stmt_product_image->rowCount();

echo "<div class='col-md-1'>";
// if count is more than zero
if ($stmt_product_image) {
    // loop through all product images
    // image name and source url
    $product_image_name = $stmt_product_image->name;
    $source = "src/uploads/images/{$product_image_name}";
    echo "<img src='{$source}' class='product-img-thumb' data-img-id='{$stmt_product_image->id}' />";

} else {
    echo "No images.";
}
echo "</div>";

echo "<div class='col-md-4' id='product-img'>";

// read all related product image
$stmt_product_image = $product_image->find_product_image_by_id($id);
// $num_product_image = $stmt_product_image->rowCount();

// if count is more than zero
if ($stmt_product_image) {
    // loop through all product images

    // image name and source url
    $product_image_name = $stmt_product_image->name;
    $source = "src/uploads/images/{$product_image_name}";
    $show_product_img = "display-block";
    echo "<a href='{$source}' target='_blank' id='product-img-{$stmt_product_image->id}' class='product-img {$show_product_img}'>";
    echo "<img src='{$source}' style='width:100%;' />";
    echo "</a>";

} else {
    echo "No images.";
}
echo "</div>";

echo "<div class='col-md-5'>";
$product = $product->find_by_id($id);
echo "<div class='product-detail'>Price:</div>";
echo "<h4 class='m-b-10px price-description'>$" . number_format($product->price, 2, '.', ',') . "</h4>";

echo "<div class='product-detail'>Product description:</div>";
echo "<div class='m-b-10px'>";
// make html
$page_description = htmlspecialchars_decode(htmlspecialchars_decode($product->description));

// show to user
echo $page_description;

// rating section
echo "</div>";
echo "  <div class='row>";
echo " <hr'>";
echo " <div class='review-block'>";

// $ratinguery = "SELECT ratingId, itemId, userId, ratingNumber, title, comments, created, modified FROM item_rating";
// $ratingQuery = $rating->find_rating_by_id($product->id);
$ratingQuery = $rating->get_rating_by_id($product->id);

foreach ($ratingQuery as $rating) {

    $date = date_create($rating->created);
    $reviewDate = date_format($date, "M d, Y");
    ?>
    <div class="row">
        <div class="col-sm-3">
            <div class="review-block-date"><?php echo $reviewDate; ?></div>
        </div>
        <div class="col-sm-9">
            <div class="review-block-rate">
                <?php
                for ($i = 1; $i <= 5; $i++) {
                    $ratingClass = "btn-default btn-grey";
                    if ($i <= $rating->ratingNumber) {
                        $ratingClass = "btn-warning";
                    }
                    ?>
                    <button type="button" class="btn btn-xs <?php echo $ratingClass; ?>" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                <?php } ?>
            </div>
        </div>
    </div>
    <hr/>
<?php } ?>
</div>
</div>
</div>"
<div class="col-sm-7">

    <?php
    echo "</div>";

    if ($rating->userId != 1) {
        # code...
        echo "<div class='row'>
                <div class='col-sm-12'>
                   <form id='ratingForm' method='POST'>
                       <div class='form-group'>
                            <h4>Rate this product</h4>
                            <button type='button' class='btn btn-warning btn-sm rateButton' aria-label='Left Align'>
                                <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
                            </button>
                            <button type='button' class='btn btn-default btn-grey btn-sm rateButton' aria-label='Left Align'>
                                <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
                            </button>
                            <button type='button' class='btn btn-default btn-grey btn-sm rateButton' aria-label='Left Align'>
                                <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
                            </button>
                            <button type='button' class='btn btn-default btn-grey btn-sm rateButton' aria-label='Left Align'>
                                <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
                            </button>
                            <button type='button' class='btn btn-default btn-grey btn-sm rateButton' aria-label='Left Align'>
                            <span class='glyphicon glyphicon-star' aria-hidden='true'></span>
                            </button>
                    <input type='hidden' class='form-control' id='rating' name='rating' value='1'>
                    <input type='hidden' class='form-control' id='itemId' name='itemId' value='$product->id'>
                    </div>

                    <div class='form-group'>
                    <button type='submit' class='btn btn-info' id='saveReview'>Save Review</button> <button type='button' class='btn btn-info' id='cancelReview'>Cancel</button>    
                    </div>   
                     </form>
                    </div>
                    </div>";
    }


    echo "<div class='col-md-2'>";
    // cart item settings
    $cart_item->user_id = 1; // we default to a user with ID "1" for now
    $cart_item->product_id = $id;

    // if product was already added in the cart
    if ($cart_item->exists($product->id)) {
        echo "<div class='m-b-10px'>This product is already in your cart.</div>
                <a href='cart.php' class='btn btn-success w-100-pct'>
                        Update Cart
                 </a>";
    } // if product was not added to the cart yet
    else {

        echo "<form class='add-to-cart-form'>
                <div class='product-id display-none'>{$id}</div>
                    <div class='m-b-10px f-w-b'>Quantity:</div>
                        <input type='number' class='form-control m-b-10px cart-quantity' value='1' min='1' />
                            <button style='width:100%;' type='submit' class='btn btn-primary add-to-cart m-b-10px'>
                                <span class='glyphicon glyphicon-shopping-cart'></span> Add to cart
                                </button>

                </form>";
    }
    echo "</div>";

    ?>

