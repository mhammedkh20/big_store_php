<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: applocation/json');

include_once '././include/config/Database.php';
include_once './models/posts.php';
include_once './models/Delete.php';
include_once './models/Puts.php';
include_once './models/Guts.php';

$database = new Database();
$customer = new GutDatabase($database->connect());

$customer->getStaffsBelongingToMagagers();

//$data = json_decode(file_get_contents('php://input'));
//
////echo json_encode($data);
//
//if ($customer->postGroupCategory($data)) {
//    echo json_encode(
//            array('msg' => 'post row success')
//    );
//} else {
//    echo json_encode(
//            array('msg' => 'no post success')
//    );
//}

