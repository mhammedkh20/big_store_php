<?php

class GutDatabase {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getPaginationCustomers() {

        $page = !isset($_GET['page']) ? $page = 1 : $_GET['page'];
        $order = !isset($_GET['order']) ? $order = 'asc' : $_GET['order'];

        $rangePagination = 30;
        $countCustomer = $this->getCountRowTable('customers');
        $numberPage = ceil($countCustomer / $rangePagination);

        $starting_limit_number = ($page - 1) * $rangePagination;
        $sql = 'select * from customers ORDER BY customer_id ' . $order . ' limit ' . $starting_limit_number . ',' . $rangePagination;

        $customer_arr = array(
            'flag' => 0,
            'num_page' => 0,
            'msg' => 'invalid request',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $customer_arr['data'] = array();
            $customer_arr['flag'] = 1;
            $customer_arr['num_page'] = $numberPage;
            $customer_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $customer_item = array(
                    'customer_id' => $row['customer_id'],
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'password' => $row['password'],
                    'phone' => $row['phone'],
                    'email' => $row['email'],
                    'street' => $row['street'],
                    'city' => $row['city'],
                    'is_admin' => $row['is_admin'],
                    'created_at' => $row['created_at'],
                    'updated_at' => $row['updated_at'],
                );
                array_push($customer_arr['data'], $customer_item);
            }

            echo json_encode($customer_arr);
        } else {
            $customer_arr['msg'] = 'There is no data currently';
            echo json_encode($customer_arr);
        }
    }

    public function getPaginationPoints() {

        $page = !isset($_GET['page']) ? $page = 1 : $_GET['page'];
        $order = !isset($_GET['order']) ? $order = 'asc' : $_GET['order'];

        $rangePagination = 30;
        $count = $this->getCountRowTable('points');
        $numberPage = ceil($count / $rangePagination);

        $starting_limit_number = ($page - 1) * $rangePagination;
        $sql = 'select * from points ORDER BY point_id ' . $order . ' limit ' . $starting_limit_number . ',' . $rangePagination;

        $data_arr = array(
            'flag' => 0,
            'num_page' => 0,
            'msg' => 'invaled request',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;
            $data_arr['num_page'] = $numberPage;
            $data_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'point_id' => $row['point_id'],
                    'customer_id' => $row['customer_id'],
                    'city' => $row['city'],
                    'street' => $row['street'],
                    'place_detail' => $row['place_detail'],
                    'location' => $row['location'],
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'phone' => $row['phone'],
                );
                array_push($data_arr['data'], $data_item);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getPaginationOrders() {

        $page = !isset($_GET['page']) ? $page = 1 : $_GET['page'];
        $order = !isset($_GET['order']) ? $order = 'asc' : $_GET['order'];

        $rangePagination = 30;
        $count = $this->getCountRowTable('orders');
        $numberPage = ceil($count / $rangePagination);

        $starting_limit_number = ($page - 1) * $rangePagination;
        $sql = 'SELECT orders.order_id,
                orders.customer_id,
                orders.point_id,
                orders.store_id, 
                customers.first_name,
                customers.last_name,
                customers.phone,
                points.location,
                stores.store_name,
                orders.order_status,
                orders.order_date,
                orders.total_price
                FROM orders
                LEFT OUTER JOIN customers ON orders.customer_id = customers.customer_id 
                LEFT OUTER JOIN points ON orders.point_id = points.point_id 
                LEFT OUTER JOIN stores ON orders.store_id = stores.store_id
                ORDER BY orders.order_id ' . $order . ' limit ' . $starting_limit_number . ',' . $rangePagination;

        $data_arr = array(
            'flag' => 0,
            'num_page' => 0,
            'msg' => 'invaled request',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;
            $data_arr['num_page'] = $numberPage;
            $data_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'order_id' => $row['order_id'],
                    'customer_id' => $row['customer_id'],
                    'point_id' => $row['point_id'],
                    'store_id' => $row['store_id'],
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'phone' => $row['phone'],
                    'location' => $row['location'],
                    'store_name' => $row['store_name'],
                    'order_status' => $row['order_status'],
                    'order_date' => $row['order_date'],
                    'total_price' => $row['total_price'],
                );
                array_push($data_arr['data'], $data_item);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getItemsOrder() {

        $order_id = !isset($_GET['order-id']) ? $order_id = 1 : $_GET['order-id'];

        $sql = 'SELECT 
                products.product_id,
                products.store_id,
                products.product_name,
                order_items.quantity, 
                order_items.unit_price,
                order_items.total_prices,
                order_items.discount 
                FROM order_items
                INNER JOIN products ON products.product_id = order_items.product_id 
                WHERE order_items.order_id = ' . $order_id;

        $data_arr = array(
            'flag' => 0,
            'msg' => 'invaled request',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {

            $data_arr['data'] = array();
            $data_arr['flag'] = 1;

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'product_id' => $row['product_id'],
                    'store_id' => $row['store_id'],
                    'product_name' => $row['product_name'],
                    'quantity' => $row['quantity'],
                    'unit_price' => $row['unit_price'],
                    'total_prices' => $row['total_prices'],
                    'discount' => $row['discount'],
                );
                array_push($data_arr['data'], $data_item);
            }
            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getPaginationStores() {

        $page = !isset($_GET['page']) ? $page = 1 : $_GET['page'];
        $order = !isset($_GET['order']) ? $order = 'asc' : $_GET['order'];

        $rangePagination = 30;
        $count = $this->getCountRowTable('stores');
        $numberPage = ceil($count / $rangePagination);

        $starting_limit_number = ($page - 1) * $rangePagination;
        $sql = 'select * from stores ORDER BY store_id ' . $order . ' limit ' . $starting_limit_number . ',' . $rangePagination;

        $data_arr = array(
            'flag' => 0,
            'num_page' => 0,
            'msg' => 'invaled request',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;
            $data_arr['num_page'] = $numberPage;
            $data_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'store_id' => $row['store_id'],
                    'store_name' => $row['store_name'],
                    'store_describe' => $row['store_describe'],
                    'phone' => $row['phone'],
                    'phone_whatsApp' => $row['phone_whatsApp'],
                    'url_facebook' => $row['url_facebook'],
                    'url_instegram' => $row['url_instegram'],
                    'street' => $row['street'],
                    'city' => $row['city'],
                    'location' => $row['location'],
                    'state' => $row['state'],
                    'image_store' => $row['image_store'],
                );
                $data_item['images'] = array();

                $sql_image = 'SELECT image_id , path_image FROM store_images WHERE store_id = ' . $row['store_id'];

                $stmt_image = $this->conn->prepare($sql_image);
                $stmt_image->execute();

                $result_image = $stmt_image;
                if ($result_image->rowCount() > 0) {
                    while ($row_images = $result_image->fetch(PDO::FETCH_ASSOC)) {

                        $data_item_image = array(
                            'image_id' => $row_images['image_id'],
                            'url_image' => $row_images['path_image']
                        );
                        array_push($data_item['images'], $data_item_image);
                    }
                }
                array_push($data_arr['data'], $data_item);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getStores() {

        $sql = 'select * from stores ORDER BY store_id ' . 'desc' . ' limit ' . 0 . ',' . 10;

        $data_arr = array(
            'flag' => 0,
            'msg' => 'invaled request',
            'name' => 'المتاجر',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['flag'] = 1;
            $data_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'id' => $row['store_id'],
                    'name' => $row['store_name'],
                    'icon' => $row['image_store'],
                );
                array_push($data_arr['data'], $data_item);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }
    
    public function getPaginationManagers() {

        $page = !isset($_GET['page']) ? $page = 1 : $_GET['page'];
        $order = !isset($_GET['order']) ? $order = 'asc' : $_GET['order'];

        $rangePagination = 30;
        $count = $this->getCountRowTable('managers');
        $numberPage = ceil($count / $rangePagination);

        $starting_limit_number = ($page - 1) * $rangePagination;
        $sql = 'select * from managers ORDER BY manager_id ' . $order . ' limit ' . $starting_limit_number . ',' . $rangePagination;

        $data_arr = array(
            'flag' => 0,
            'num_page' => 0,
            'msg' => 'invaled request',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;
            $data_arr['num_page'] = $numberPage;
            $data_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'manager_id' => $row['manager_id'],
                    'store_id' => $row['store_id'],
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'email' => $row['email'],
                    'password' => $row['password'],
                    'phone' => $row['phone'],
                    'active' => $row['active'],
                    'personal_picture' => $row['personal_picture'],
                );
                array_push($data_arr['data'], $data_item);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getManagers() {

        $sql = 'select * from managers ORDER BY manager_id ' . 'desc' . ' limit ' . 0 . ',' . 10;

        $data_arr = array(
            'flag' => 0,
            'msg' => 'invaled request',
            'name' => 'مدراء المتاجر',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;
            $data_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'id' => $row['manager_id'],
                    'name' => $row['first_name'] . ' ' . $row['last_name'],
                    'icon' => $row['personal_picture'],
                );
                array_push($data_arr['data'], $data_item);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getPaginationStaffs() {

        $page = !isset($_GET['page']) ? $page = 1 : $_GET['page'];
        $order = !isset($_GET['order']) ? $order = 'asc' : $_GET['order'];

        $rangePagination = 30;
        $count = $this->getCountRowTable('staffs');
        $numberPage = ceil($count / $rangePagination);

        $starting_limit_number = ($page - 1) * $rangePagination;
        $sql = 'select * from staffs ORDER BY staff_id ' . $order . ' limit ' . $starting_limit_number . ',' . $rangePagination;

        $data_arr = array(
            'flag' => 0,
            'num_page' => 0,
            'msg' => 'invaled request',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;
            $data_arr['num_page'] = $numberPage;
            $data_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'staff_id' => $row['staff_id'],
                    'manager_id' => $row['manager_id'],
                    'store_id' => $row['store_id'],
                    'first_name' => $row['first_name'],
                    'last_name' => $row['last_name'],
                    'email' => $row['email'],
                    'password' => $row['password'],
                    'phone' => $row['phone'],
                    'active' => $row['active'],
                    'personal_picture' => $row['personal_picture'],
                );
                array_push($data_arr['data'], $data_item);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getStaffs() {

        $sql = 'select * from staffs ORDER BY staff_id ' . 'desc' . ' limit ' . 0 . ',' . 10;

        $data_arr = array(
            'flag' => 0,
            'msg' => 'invaled request',
            'name' => 'موظفين المتاجر',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;
            $data_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'id' => $row['staff_id'],
                    'name' => $row['first_name'].' '.$row['last_name'],
                    'icon' => $row['personal_picture'],
                );
                array_push($data_arr['data'], $data_item);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getCategories() {

        $order = !isset($_GET['order']) ? $order = 'asc' : $_GET['order'];

        $sql = 'select * from categories ORDER BY category_name ' . $order;

        $data_arr = array(
            'flag' => 0,
            'msg' => 'invaled request',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;
            $data_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'category_id' => $row['category_id'],
                    'category_name' => $row['category_name'],
                    'category_icon' => $row['category_icon'],
                );
                array_push($data_arr['data'], $data_item);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getCategories1() {

        $order = !isset($_GET['order']) ? $order = 'asc' : $_GET['order'];

        $sql = 'select * from categories ORDER BY category_id ' . $order;

        $data_arr = array(
            'flag' => 0,
            'msg' => 'invaled request',
            'name' => 'الفئات الرئيسية',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;
            $data_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'id' => $row['category_id'],
                    'name' => $row['category_name'],
                    'icon' => $row['category_icon'],
                );
                array_push($data_arr['data'], $data_item);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getBrands() {

        $order = !isset($_GET['order']) ? $order = 'asc' : $_GET['order'];

        $sql = 'select * from brands ORDER BY brand_name ' . $order;

        $data_arr = array(
            'flag' => 0,
            'msg' => 'invaled request',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;
            $data_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'brand_id' => $row['brand_id'],
                    'brand_name' => $row['brand_name'],
                    'brand_icon' => $row['brand_icon'],
                );
                array_push($data_arr['data'], $data_item);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getBrands1() {

        $order = !isset($_GET['order']) ? $order = 'desc' : $_GET['order'];

        $sql = 'select * from brands ORDER BY brand_id ' . $order;

        $data_arr = array(
            'flag' => 0,
            'msg' => 'invaled request',
            'name' => 'الماركات',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;
            $data_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'id' => $row['brand_id'],
                    'name' => $row['brand_name'],
                    'icon' => $row['brand_icon'],
                );
                array_push($data_arr['data'], $data_item);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getGroupCategory() {

        $order = !isset($_GET['order']) ? $order = 'asc' : $_GET['order'];

        $sql = 'select * from groupcategories ORDER BY name_group_cat ' . $order;

        $data_arr = array(
            'flag' => 0,
            'msg' => 'invaled request',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;
            $data_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'group_cat_id' => $row['group_cat_id'],
                    'category_id' => $row['category_id'],
                    'name_group_cat' => $row['name_group_cat'],
                    'group_categories_icon' => $row['group_categories_icon'],
                );
                array_push($data_arr['data'], $data_item);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getGroupCategory1() {

        $order = !isset($_GET['order']) ? $order = 'asc' : $_GET['order'];

        $sql = 'select * from groupcategories ORDER BY group_cat_id ' . $order;

        $data_arr = array(
            'flag' => 0,
            'msg' => 'invaled request',
            'name' => 'الفئات الفرعية',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;
            $data_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'id' => $row['group_cat_id'],
                    'name' => $row['name_group_cat'],
                    'icon' => $row['group_categories_icon'],
                );
                array_push($data_arr['data'], $data_item);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getSubGroupBelongingToGroupCategory() {
        $data_arr = array(
            'flag' => 0,
            'msg' => 'invaled request',
            'data' => array()
        );

        $inner_data_arr = array(
            'id_group_cat' => 0,
            'name_group_cat' => null,
            'icon_group_cat' => null,
            'data' => array()
        );

        $sql = 'SELECT * FROM groupcategories ORDER BY group_cat_id ASC';

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;
            $data_arr['msg'] = 'data connected';


            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $inner_data_arr['data'] = array();

                $inner_data_arr['id_group_cat'] = $row['group_cat_id'];
                $inner_data_arr['name_group_cat'] = $row['name_group_cat'];
                $inner_data_arr['icon_group_cat'] = $row['group_categories_icon'];

                $sql1 = 'SELECT 
                        subgroupcat.sub_group_cat_id ,
                        subgroupcat.group_cat_id ,
                        subgroupcat.name_sub_group 
                        FROM subgroupcat 
                        RIGHT OUTER JOIN groupcategories ON subgroupcat.group_cat_id = groupcategories.group_cat_id
                        WHERE subgroupcat.group_cat_id = ' . $row['group_cat_id'] . ' ORDER BY subgroupcat.sub_group_cat_id ASC';

                $stmt1 = $this->conn->prepare($sql1);
                $stmt1->execute();
                $result1 = $stmt1;

                while ($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {

                    $data_item1 = array(
                        'subGroupCat_id' => $row1['sub_group_cat_id'],
                        'groupCat_id' => $row1['group_cat_id'],
                        'subGroup_name' => $row1['name_sub_group'],
                    );

                    array_push($inner_data_arr['data'], $data_item1);
                }

                array_push($data_arr['data'], $inner_data_arr);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getPaginationProductsBelongingToBrand() {

        $page = !isset($_GET['page']) ? $page = 1 : $_GET['page'];
        $order = !isset($_GET['order']) ? $order = 'asc' : $_GET['order'];
        $brand_id = !isset($_GET['brand-id']) ? $brand_id = 1 : $_GET['brand-id'];

        $rangePagination = 30;
        $count = $this->getCountRowTable('products');
        $numberPage = ceil($count / $rangePagination);

        $starting_limit_number = ($page - 1) * $rangePagination;
        $sql = 'select
                products.product_id ,
                products.brand_id ,
                products.store_id ,
                products.sub_group_cat_id ,
                products.product_name ,
                products.product_describe ,
                products.price ,
                products.discount ,
                products.image_product 
                FROM products
                INNER JOIN brands ON products.brand_id = brands.brand_id
                Where brands.brand_id = :id
                ORDER BY product_id ' . $order . ' limit ' . $starting_limit_number . ',' . $rangePagination;

        $data_arr = array(
            'flag' => 0,
            'num_page' => 0,
            'msg' => 'invaled request',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $brand_id);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;
            $data_arr['num_page'] = $numberPage;
            $data_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'product_id' => $row['product_id'],
                    'brand_id' => $row['brand_id'],
                    'store_id' => $row['store_id'],
                    'sub_group_cat_id' => $row['sub_group_cat_id'],
                    'product_name' => $row['product_name'],
                    'product_describe' => $row['product_describe'],
                    'price' => $row['price'],
                    'discount' => $row['discount'],
                    'image_product' => $row['image_product'],
                );
                array_push($data_arr['data'], $data_item);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getPaginationProductsBelongingToSubGroup() {

        $page = !isset($_GET['page']) ? $page = 1 : $_GET['page'];
        $order = !isset($_GET['order']) ? $order = 'asc' : $_GET['order'];
        $subGroup_id = !isset($_GET['subGroup-id']) ? $subGroup_id = 1 : $_GET['subGroup-id'];

        $rangePagination = 30;
        $count = $this->getCountRowTable('products');
        $numberPage = ceil($count / $rangePagination);

        $starting_limit_number = ($page - 1) * $rangePagination;
        $sql = 'select
                products.product_id ,
                products.brand_id ,
                products.store_id ,
                products.sub_group_cat_id ,
                products.product_name ,
                products.product_describe ,
                products.price ,
                products.discount ,
                products.image_product 
                FROM products
                INNER JOIN subgroupcat ON products.sub_group_cat_id = subgroupcat.sub_group_cat_id
                Where subgroupcat.sub_group_cat_id = :id
                ORDER BY product_id ' . $order . ' limit ' . $starting_limit_number . ',' . $rangePagination;

        $data_arr = array(
            'flag' => 0,
            'num_page' => 0,
            'msg' => 'invaled request',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $subGroup_id);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;
            $data_arr['num_page'] = $numberPage;
            $data_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'product_id' => $row['product_id'],
                    'brand_id' => $row['brand_id'],
                    'store_id' => $row['store_id'],
                    'sub_group_cat_id' => $row['sub_group_cat_id'],
                    'product_name' => $row['product_name'],
                    'product_describe' => $row['product_describe'],
                    'price' => $row['price'],
                    'discount' => $row['discount'],
                    'image_product' => $row['image_product'],
                );
                array_push($data_arr['data'], $data_item);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getPaginationProductsBelongingToGroupCategory() {

        $page = !isset($_GET['page']) ? $page = 1 : $_GET['page'];
        $order = !isset($_GET['order']) ? $order = 'asc' : $_GET['order'];
        $group_id = !isset($_GET['group-id']) ? $group_id = 1 : $_GET['group-id'];

        $rangePagination = 30;
        $count = $this->getCountRowTable('products');
        $numberPage = ceil($count / $rangePagination);

        $starting_limit_number = ($page - 1) * $rangePagination;
        $sql = 'select
                products.product_id ,
                products.brand_id ,
                products.store_id ,
                products.sub_group_cat_id ,
                products.product_name ,
                products.product_describe ,
                products.price ,
                products.discount ,
                products.image_product 
                FROM products
                INNER JOIN subgroupcat ON products.sub_group_cat_id = subgroupcat.sub_group_cat_id
                INNER JOIN groupcategories ON groupcategories.group_cat_id = subgroupcat.group_cat_id
                Where groupcategories.group_cat_id = :id
                ORDER BY product_id ' . $order . ' limit ' . $starting_limit_number . ',' . $rangePagination;

        $data_arr = array(
            'flag' => 0,
            'num_page' => 0,
            'msg' => 'invaled request',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $group_id);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;
            $data_arr['num_page'] = $numberPage;
            $data_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'product_id' => $row['product_id'],
                    'brand_id' => $row['brand_id'],
                    'store_id' => $row['store_id'],
                    'sub_group_cat_id' => $row['sub_group_cat_id'],
                    'product_name' => $row['product_name'],
                    'product_describe' => $row['product_describe'],
                    'price' => $row['price'],
                    'discount' => $row['discount'],
                    'image_product' => $row['image_product'],
                );
                array_push($data_arr['data'], $data_item);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getPaginationProductsBelongingToCategory() {

        $page = !isset($_GET['page']) ? $page = 1 : $_GET['page'];
        $order = !isset($_GET['order']) ? $order = 'asc' : $_GET['order'];
        $category_id = !isset($_GET['category-id']) ? $category_id = 1 : $_GET['category-id'];

        $rangePagination = 30;
        $count = $this->getCountRowTable('products');
        $numberPage = ceil($count / $rangePagination);

        $starting_limit_number = ($page - 1) * $rangePagination;
        $sql = 'select
                products.product_id ,
                products.brand_id ,
                products.store_id ,
                products.sub_group_cat_id ,
                products.product_name ,
                products.product_describe ,
                products.price ,
                products.discount ,
                products.image_product 
                FROM products
                INNER JOIN subgroupcat ON products.sub_group_cat_id = subgroupcat.sub_group_cat_id
                INNER JOIN groupcategories ON groupcategories.group_cat_id = subgroupcat.group_cat_id
                INNER JOIN categories ON categories.category_id = groupcategories.category_id
                Where categories.category_id = :id
                ORDER BY product_id ' . $order . ' limit ' . $starting_limit_number . ',' . $rangePagination;

        $data_arr = array(
            'flag' => 0,
            'num_page' => 0,
            'msg' => 'invaled request',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $category_id);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;
            $data_arr['num_page'] = $numberPage;
            $data_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'product_id' => $row['product_id'],
                    'brand_id' => $row['brand_id'],
                    'store_id' => $row['store_id'],
                    'sub_group_cat_id' => $row['sub_group_cat_id'],
                    'product_name' => $row['product_name'],
                    'product_describe' => $row['product_describe'],
                    'price' => $row['price'],
                    'discount' => $row['discount'],
                    'image_product' => $row['image_product'],
                );
                array_push($data_arr['data'], $data_item);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getPaginationProductsBelongingToStore() {

        $page = !isset($_GET['page']) ? $page = 1 : $_GET['page'];
        $order = !isset($_GET['order']) ? $order = 'asc' : $_GET['order'];
        $store_id = !isset($_GET['store-id']) ? $store_id = 1 : $_GET['store-id'];

        $rangePagination = 30;
        $count = $this->getCountRowTable('products');
        $numberPage = ceil($count / $rangePagination);

        $starting_limit_number = ($page - 1) * $rangePagination;
        $sql = 'select
                products.product_id ,
                products.brand_id ,
                products.store_id ,
                products.sub_group_cat_id ,
                products.product_name ,
                products.product_describe ,
                products.price ,
                products.discount ,
                products.image_product 
                FROM products
                INNER JOIN stores ON products.store_id = stores.store_id
                Where stores.store_id = :id
                ORDER BY product_id ' . $order . ' limit ' . $starting_limit_number . ',' . $rangePagination;

        $data_arr = array(
            'flag' => 0,
            'num_page' => 0,
            'msg' => 'invaled request',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $store_id);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;
            $data_arr['num_page'] = $numberPage;
            $data_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'product_id' => $row['product_id'],
                    'brand_id' => $row['brand_id'],
                    'store_id' => $row['store_id'],
                    'sub_group_cat_id' => $row['sub_group_cat_id'],
                    'product_name' => $row['product_name'],
                    'product_describe' => $row['product_describe'],
                    'price' => $row['price'],
                    'discount' => $row['discount'],
                    'image_product' => $row['image_product'],
                );
                array_push($data_arr['data'], $data_item);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getPaginationProducts() {

        $page = !isset($_GET['page']) ? $page = 1 : $_GET['page'];
        $order = !isset($_GET['order']) ? $order = 'asc' : $_GET['order'];

        $rangePagination = 30;
        $count = $this->getCountRowTable('products');
        $numberPage = ceil($count / $rangePagination);

        $starting_limit_number = ($page - 1) * $rangePagination;
        $sql = 'select
                product_id ,
                brand_id ,
                store_id ,
                sub_group_cat_id ,
                product_name ,
                product_describe ,
                price ,
                discount ,
                image_product 
                from products ORDER BY product_id ' . $order . ' limit ' . $starting_limit_number . ',' . $rangePagination;

        $data_arr = array(
            'flag' => 0,
            'num_page' => 0,
            'msg' => 'invaled request',
            'data' => array()
        );

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $result = $stmt;

        if ($result->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;
            $data_arr['num_page'] = $numberPage;
            $data_arr['msg'] = 'data connected';

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'product_id' => $row['product_id'],
                    'brand_id' => $row['brand_id'],
                    'store_id' => $row['store_id'],
                    'sub_group_cat_id' => $row['sub_group_cat_id'],
                    'product_name' => $row['product_name'],
                    'product_describe' => $row['product_describe'],
                    'price' => $row['price'],
                    'discount' => $row['discount'],
                    'image_product' => $row['image_product'],
                );
                array_push($data_arr['data'], $data_item);
            }

            echo json_encode($data_arr);
        } else {
            $data_arr['msg'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getStaffsBelongingToMagagers() {
        $store_id = !isset($_GET['store-id']) ? $store_id = 1 : $_GET['store-id'];

        $sql_manager = 'SELECT * FROM managers WHERE store_id = ' . $store_id;
        $stmt_manager = $this->conn->prepare($sql_manager);
        $stmt_manager->execute();

        $data_arr = array(
            'flag' => 0,
            'msg' => 'invalid request',
            'data' => array()
        );

        $result_manager = $stmt_manager;

        if ($result_manager->rowCount() > 0) {
            $data_arr['data'] = array();
            $data_arr['flag'] = 1;

            while ($row_data_manager = $result_manager->fetch(PDO::FETCH_ASSOC)) {
                $data = array(
                    'manager_id' => $row_data_manager['manager_id'],
                    'store_id' => $row_data_manager['store_id'],
                    'first_name' => $row_data_manager['first_name'],
                    'last_name' => $row_data_manager['last_name'],
                    'email' => $row_data_manager['email'],
                    'password' => $row_data_manager['password'],
                    'phone' => $row_data_manager['phone'],
                    'active' => $row_data_manager['active'],
                    'personal_picture' => $row_data_manager['personal_picture'],
                    'staffs' => array(),
                );

                $sql_staff = 'SELECT * FROM staffs'
                        . ' WHERE manager_id = ' . $row_data_manager['manager_id'];

                $stmt_staff = $this->conn->prepare($sql_staff);

                $stmt_staff->execute();
                $result_staff = $stmt_staff;

                if ($result_staff->rowCount() > 0) {

                    while ($row_staff = $result_staff->fetch(PDO::FETCH_ASSOC)) {
                        $data_item = array(
                            'staff_id' => $row_staff['staff_id'],
                            'manager_id' => $row_staff['manager_id'],
                            'store_id' => $row_staff['store_id'],
                            'first_name' => $row_staff['first_name'],
                            'last_name' => $row_staff['last_name'],
                            'email' => $row_staff['email'],
                            'password' => $row_staff['password'],
                            'phone' => $row_staff['phone'],
                            'active' => $row_staff['active'],
                            'personal_picture' => $row_staff['personal_picture'],
                        );
                        array_push($data['staffs'], $data_item);
                    }
                }
                array_push($data_arr['data'], $data);
            }
            echo json_encode($data_arr);
        } else {
            $data_arr['data'] = 'There is no data currently';
            echo json_encode($data_arr);
        }
    }

    public function getAllProductData() {

        $product_id = !isset($_GET['product-id']) ? $product_id = 1 : $_GET['product-id'];

        $sql_product = 'SELECT * FROM products WHERE product_id = :id';

        $stmt_product = $this->conn->prepare($sql_product);
        $stmt_product->bindParam(':id', $product_id);

        $stmt_product->execute();

        $row_data_product = $stmt_product->fetch(PDO::FETCH_ASSOC);
        $data = array(
            'product_id' => $row_data_product['product_id'],
            'product_name' => $row_data_product['product_name'],
            'product_describe' => $row_data_product['product_describe'],
            'store_id' => $row_data_product['store_id'],
            'brand_id' => $row_data_product['brand_id'],
            'sub_group_cat_id' => $row_data_product['sub_group_cat_id'],
            'price' => $row_data_product['price'],
            'discount' => $row_data_product['discount'],
            'image_product' => $row_data_product['image_product'],
            'front_photo' => array(),
            'detailed_photo' => array(),
            'product_variations' => array(),
            'rating' => 0,
            'comments' => array(),
        );

        $sql_front_photo = 'SELECT image_id , path_image FROM product_front_photos WHERE product_id = :id';

        $stmt_front_photo = $this->conn->prepare($sql_front_photo);
        $stmt_front_photo->bindParam(':id', $product_id);

        $stmt_front_photo->execute();
        $result_front_photo = $stmt_front_photo;

        if ($result_front_photo->rowCount() > 0) {
            $data['front_photo'] = array();

            while ($row_front = $result_front_photo->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'image_id' => $row_front['image_id'],
                    'URL_image' => $row_front['path_image']
                );
                array_push($data['front_photo'], $data_item);
            }
        }

        $sql_detailed_photo = 'SELECT image_id , path_image FROM product_detailed_photos WHERE product_id = :id';

        $stmt_detailed_photo = $this->conn->prepare($sql_detailed_photo);
        $stmt_detailed_photo->bindParam(':id', $product_id);

        $stmt_detailed_photo->execute();
        $result_detailed_photo = $stmt_detailed_photo;

        if ($result_detailed_photo->rowCount() > 0) {
            $data['detailed_photo'] = array();

            while ($row_detailed = $result_detailed_photo->fetch(PDO::FETCH_ASSOC)) {
                $data_item1 = array(
                    'image_id' => $row_detailed['image_id'],
                    'URL_image' => $row_detailed['path_image']
                );
                array_push($data['detailed_photo'], $data_item1);
            }
        }
        $inner_data_arr = array(
            'variation_name' => null,
            'variation_options' => null
        );
        $sql = 'SELECT product_var_id ,'
                . 'variation_name '
                . 'FROM products_variations '
                . 'WHERE product_id = ' . $product_id . ' '
                . 'ORDER BY product_var_id ASC';

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt;

        if ($result->rowCount() > 0) {

            $data['product_variations'] = array();

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $inner_data_arr['variation_options'] = array();

                $inner_data_arr['variation_name'] = $row['variation_name'];

                $sql1 = 'SELECT 
                        product_variations_options.variation_option ,
                        product_variations_options.add_price 
                        FROM product_variations_options 
                        INNER JOIN products_variations ON products_variations.product_var_id = product_variations_options.product_var_id
                        WHERE products_variations.product_var_id = ' . $row['product_var_id'];

                $stmt1 = $this->conn->prepare($sql1);
                $stmt1->execute();
                $result1 = $stmt1;

                while ($row1 = $result1->fetch(PDO::FETCH_ASSOC)) {

                    $data_item1 = array(
                        'variation_option' => $row1['variation_option'],
                        'add_price' => $row1['add_price']
                    );

                    array_push($inner_data_arr['variation_options'], $data_item1);
                }
                array_push($data['product_variations'], $inner_data_arr);
            }
        }

        $sql_avgRatings = 'SELECT  AVG(rating) as avg_ratings '
                . 'FROM ratings '
                . 'WHERE product_id = ' . $product_id;

        $stmt_ratings = $this->conn->prepare($sql_avgRatings);

        $stmt_ratings->execute();
        $result_ratings = $stmt_ratings;

        if ($result_ratings->rowCount() > 0) {
            $rating = $result_ratings->fetch(PDO::FETCH_ASSOC);
            $data['rating'] = $rating['avg_ratings'];
        }

        $sql_comment = 'SELECT '
                . 'customers.customer_id ,'
                . 'customers.first_name ,'
                . 'customers.last_name ,'
                . 'comments.comment '
                . 'FROM comments '
                . 'INNER JOIN ratings ON ratings.rating_id = comments.rating_id '
                . 'INNER JOIN orders ON orders.order_id = ratings.order_id '
                . 'INNER JOIN customers ON orders.customer_id = customers.customer_id '
                . 'WHERE ratings.product_id = ' . $product_id;

        $stmt_comment = $this->conn->prepare($sql_comment);

        $stmt_comment->execute();
        $result_comment = $stmt_comment;

        if ($result_comment->rowCount() > 0) {
            $data['comments'] = array();

            while ($row_comment = $result_comment->fetch(PDO::FETCH_ASSOC)) {
                $data_comment = array(
                    'customer_id' => $row_comment['customer_id'],
                    'first_name' => $row_comment['first_name'],
                    'last_name' => $row_comment['last_name'],
                    'comment' => $row_comment['comment'],
                );
                array_push($data['comments'], $data_comment);
            }
        }

        echo json_encode($data);
    }

    public function getAllCustomerData() {

        $customer_id = !isset($_GET['customer-id']) ? $customer_id = 1 : $_GET['customer-id'];

        $sql_customer = 'SELECT * FROM customers WHERE customer_id = :id';

        $stmt_customer = $this->conn->prepare($sql_customer);
        $stmt_customer->bindParam(':id', $customer_id);

        $stmt_customer->execute();

        $row_data_customer = $stmt_customer->fetch(PDO::FETCH_ASSOC);
        $data = array(
            'customer_id' => $row_data_customer['customer_id'],
            'first_name' => $row_data_customer['first_name'],
            'last_name' => $row_data_customer['last_name'],
            'password' => $row_data_customer['password'],
            'phone' => $row_data_customer['phone'],
            'email' => $row_data_customer['email'],
            'street' => $row_data_customer['street'],
            'city' => $row_data_customer['city'],
            'is_admin' => $row_data_customer['is_admin'],
            'created_at' => $row_data_customer['created_at'],
            'updated_at' => $row_data_customer['updated_at'],
            'points' => array(),
        );

        $sql_point = 'SELECT point_id , city , street , location FROM points'
                . ' WHERE customer_id = :id';

        $stmt_point = $this->conn->prepare($sql_point);
        $stmt_point->bindParam(':id', $customer_id);

        $stmt_point->execute();
        $result_point = $stmt_point;

        if ($result_point->rowCount() > 0) {
            $data['points'] = array();

            while ($row_point = $result_point->fetch(PDO::FETCH_ASSOC)) {
                $data_item = array(
                    'point_id' => $row_point['point_id'],
                    'city' => $row_point['city'],
                    'street' => $row_point['street'],
                    'location' => $row_point['location'],
                );
                array_push($data['points'], $data_item);
            }
        }
        echo json_encode($data);
    }

    public function getCountRowTable($table) {
        $count = $this->getAllData($table);
        return $count->rowCount();
    }

    public function getAllData($table) {
        $query = 'select * from ' . $table; // desc  asc
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

}
