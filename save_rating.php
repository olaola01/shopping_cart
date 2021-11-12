<?php

include "vendor/autoload.php";
include "src/initialize.php";

use Src\helper\Path;
use Src\helper\StringUtils;
use Src\models\Ratings;


$rating = new Ratings;
$path = new Path;

if ($path->is_post_request()) {
    if (!empty($_POST['rating']) && !empty($_POST['itemId'])) {
        $rating->productId = $_POST['productId'];
        $rating->userId = 1;
        $rating->ratingNumber = $_POST['rating'];
        $rating->created = date("Y-m-d H:i:s");
        $rating->create();
        echo "rating saved!";
    }
}