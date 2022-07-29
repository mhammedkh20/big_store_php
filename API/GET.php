<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: applocation/json');
header('Access-Control-Allow-Methods: GET');

include_once '././../include/config/Database.php';
include_once '../models/Guts.php';

$database = new Database();

$data = new GutDatabase($database->connect());

$method = !isset($_GET['method']) ? $method = 'customers' : $_GET['method'];

switch ($method) {
    case 'customers':
        $data->getPaginationCustomers();
        break;
    case 'points':
        $data->getPaginationPoints();
        break;
    case 'orders':
        $data->getPaginationOrders();
        break;
    case 'items_order':
        $data->getItemsOrder();
        break;
    case 'stores':
        $data->getPaginationStores();
        break;
    case 'stores1':
        $data->getStores();
        break;
    case 'managers':
        $data->getPaginationManagers();
        break;
    case 'managers1':
        $data->getManagers();
        break;
    case 'staffs':
        $data->getPaginationStaffs();
        break;
    case 'staffs1':
        $data->getStaffs();
        break;
    case 'categories':
        $data->getCategories();
        break;
    case 'categories1':
        $data->getCategories1();
        break;
    case 'brands':
        $data->getBrands();
        break;
    case 'brands1':
        $data->getBrands1();
        break;
    case 'group_category':
        $data->getGroupCategory();
        break;
    case 'group_category1':
        $data->getGroupCategory1();
        break;
    case 'sub_gb-gb_cat':
        $data->getSubGroupBelongingToGroupCategory();
        break;
    case 'product-brand':
        $data->getPaginationProductsBelongingToBrand();
        break;
    case 'product-sub_gb':
        $data->getPaginationProductsBelongingToSubGroup();
        break;
    case 'product-gb_cat':
        $data->getPaginationProductsBelongingToGroupCategory();
        break;
    case 'product-category':
        $data->getPaginationProductsBelongingToCategory();
        break;
    case 'product-store':
        $data->getPaginationProductsBelongingToStore();
        break;
    case 'products':
        $data->getPaginationProducts();
        break;
    case 'staff-manager':
        $data->getStaffsBelongingToMagagers();
        break;
    case 'all_data_product':
        $data->getAllProductData();
        break;
    case 'all_data_customer':
        $data->getAllCustomerData();
        break;
}

