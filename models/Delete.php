<?php

Class DeleteDatabase {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function deleteRowData($data) {
        $tableName = $data->name_table;
        $id = isset($data->id) ? $data->id : '';
        $field = $data->name_field;

        $query = "delete from $tableName where $field = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function deleteRowDataWithImage($data) {

        $id = $data->id;
        $tableName = $data->table_name;
        $name_image = $data->name_image;
        $field = $data->name_field;

        $query = "delete from $tableName where $field = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0){
                switch ($tableName) {
                case "brands":
                    $path_image = "../Big_store/include/images/icon-brands/$name_image";
                    @unlink($path_image);
                    break;
                case "categories":
                    $path_image = "../Big_store/include/images/icon-categories/$name_image";
                    @unlink($path_image);
                    break;
                case "groupcategories":
                    $path_image = "../Big_store/include/images/image-group-category/$name_image";
                    @unlink($path_image);
                    break;
                case "managers":
                    $path_image = "../Big_store/include/images/image-managers/$name_image";
                    @unlink($path_image);
                    break;
                case "product_detailed_photos":
                    $path_image = "../Big_store/include/images/image-product-detailed-photos/$name_image";
                    @unlink($path_image);
                    break;
                case "product_front_photos":
                    $path_image = "../Big_store/include/images/image-product-front-photos/$name_image";
                    @unlink($path_image);
                    break;
                case "staffs":
                    $path_image = "../Big_store/include/images/image-staffs/$name_image";
                    @unlink($path_image);
                    break;
                case "store_images":
                    $path_image = "../Big_store/include/images/image-stores/$name_image";
                    @unlink($path_image);
                    break;
                case "stores":
                    $path_image = "../Big_store/include/images/image-stores/$name_image";
                    @unlink($path_image);
                    break;
                case "products":
                    $path_image = "../Big_store/include/images/image-products/$name_image";
                    @unlink($path_image);
                    break;
            }
                return true;
            }else{
                return false;
            }
        }

        return false;
    }

}
