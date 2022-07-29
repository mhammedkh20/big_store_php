<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: applocation/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,'
        . 'Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '././../include/config/Database.php';
include_once '../models/Puts.php';

$database = new Database();

$update = new UpdateDatabase($database->connect());

$data = json_decode(file_get_contents('php://input'));

$method = !isset($_GET['method']) ? $method = 'customer' : $_GET['method'];
$check = false;

switch ($method) {
    case 'customer':
        $check = $update->putCustomer($data);
        break;
    case 'point':
        $check = $update->putPoint($data);
        break;
    case 'order':
        $check = $update->putOrder($data);
        break;
    case 'items_order':
        $check = $update->putOrderItem($data);
        break;
    case 'store':
        $check = $update->putStore($data);
        break;
    case 'manager':
        $check = $update->putManager($data);
        break;
    case 'staffs':
        $check = $update->putStaff($data);
        break;
    case 'category':
        $check = $update->putCategory($data);
        break;
    case 'brand':
        $check = $update->putBrand($data);
        break;
    case 'group_category':
        $check = $update->putGroupCategory($data);
        break;
    case 'sub_gb_cat':
        $check = $update->putSubGroupCategory($data);
        break;
    case 'product':
        $check = $update->putProduct($data);
        break;
    case 'products_variations':
        $check = $update->putProductVariations($data);
        break;
    case 'products_variation_options':
        $check = $update->putProductVariationOptions($data);
        break;
    case 'rating':
        $check = $update->putRating($data);
        break;
    case 'comment':
        $check = $update->putComments($data);
        break;
}

if ($check) {
    echo json_encode(
            array('msg' => 'update row Success')
    );
} else {
    echo json_encode(
            array('msg' => 'update row Failure')
    );
}