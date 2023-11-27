<?php

require_once $_SERVER['DOCUMENT_ROOT']."/backend/database/DB.php";
require_once $_SERVER['DOCUMENT_ROOT']."/backend/Class/Reviews.php";

$DB = DB::connect();
$Reviews = new Reviews();

$rating = $_POST['rating'];
$product_id = $_POST['product_id'];
$order_id = $_POST['order'];

if ($_POST['dignities']) {
    $dignities = $_POST['dignities'];
}
else {
    $dignities = NULL;
}

if ($_POST['disadvantages']) {
    $disadvantages = $_POST['disadvantages'];
}
else {
    $disadvantages = NULL;
}

if ($_POST['comment']) {
    $comment = $_POST['comment'];
}
else {
    $comment = NULL;
}

if ($_POST['arrayImg']) {
    $arrayImg = json_decode($_POST['arrayImg']);
    if(!empty($arrayImg)) {
        ImageTransfer($arrayImg);
        $arrayImg = json_encode($arrayImg);
    }
    else $arrayImg = NULL;
}
else $arrayImg = NULL;

$array = [
    $_COOKIE['unique_id'], $product_id, $order_id, $rating, $dignities, $disadvantages, $comment, $arrayImg
];

$idReviews = $Reviews->Create($array);

function ImageTransfer($array): void
{
    foreach ($array as $item) {
        $sourcePath = $_SERVER['DOCUMENT_ROOT'].'/temp/'.$item;
        $destinationPath = $_SERVER['DOCUMENT_ROOT'].'/res/img/reviews/'.$item;
        rename($sourcePath, $destinationPath);
    }
}


echo json_encode("save");