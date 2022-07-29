<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: applocation/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,'
        . 'Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '././../include/config/Database.php';
include_once '../models/Posts.php';

$database = new Database();

$insert = new InsertDatabase($database->connect());

$data = json_decode(file_get_contents('php://input'));

$method = !isset($_GET['method']) ? $method = 'customer' : $_GET['method'];
$check = false;

switch ($method) {
    case 'customer':
        $check = $insert->postCustomer($data);
        break;
    case 'point':
        $check = $insert->postPoint($data);
        break;
    case 'order':
        $check = $insert->postOrder($data);
        break;
    case 'items_order':
        $check = $insert->postOrderItem($data);
        break;
    case 'store':
        $check = $insert->postStore($data);
        break;
    case 'store_image':
        $check = $insert->postStoreImage($data);
        break;
    case 'manager':
        $check = $insert->postManagerBody($data);
        break;
    case 'staffs':
        $check = $insert->postStaff($data);
        break;
    case 'category':
        $check = $insert->postCategory($data);
        break;
    case 'brand':
        $check = $insert->postBrand($data);
        break;
    case 'group_category':
        $check = $insert->postGroupCategory($data);
        break;
    case 'sub_gb_cat':
        $check = $insert->postSubGroupCategory($data);
        break;
    case 'product':
        $check = $insert->postProduct($data);
        break;
    case 'front_photo_product':
        $check = $insert->postProductFrontPhotos($data);
        break;
    case 'detailed_photo_product':
        $check = $insert->postProductDetailedPhotos($data);
        break;
    case 'products_variations':
        $check = $insert->postProductVariations($data);
        break;
    case 'products_variation_options':
        $check = $insert->postProductVariationOptions($data);
        break;
    case 'rating':
        $check = $insert->postRating($data);
        break;
    case 'comment':
        $check = $insert->postComments($data);
        break;
}

if ($check) {
    echo json_encode(
            array('msg' => 'insert row Success')
    );
} else {
    echo json_encode(
            array('msg' => 'insert row Failure')
    );
}