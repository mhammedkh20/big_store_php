<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: applocation/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,'
        . 'Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '././../include/config/Database.php';
include_once '../models/Delete.php';

$database = new Database();

$delete = new DeleteDatabase($database->connect());

$data = json_decode(file_get_contents('php://input'));

$method = !isset($_GET['method']) ? $method = 'text' : $_GET['method'];

$check = false;

switch ($method) {
    case 'text':
        $check = $delete->deleteRowData($data);
        break;
    case 'text-image':
        $check = $delete->deleteRowDataWithImage($data);
        break;
}
if ($check) {
    echo json_encode(
            array('msg' => 'delete row Success')
    );
} else {
    echo json_encode(
            array('msg' => 'delete row Failure')
    );
}