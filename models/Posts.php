<?php

class InsertDatabase {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function postCustomer($data) {
        $query = 'insert into ' . 'customers' .
                ' set first_name = :first_name,'
                . 'last_name = :last_name,'
                . 'password = :password,'
                . 'phone = :phone,'
                . 'email = :email,'
                . 'street = :street,'
                . 'city = :city,'
                . 'is_admin = :is_admin,'
                . 'created_at = :created_at,'
                . 'updated_at = :updated_at';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':first_name', $data->first_name);
        $stmt->bindParam(':last_name', $data->last_name);
        $stmt->bindParam(':password', $data->password);
        $stmt->bindParam(':phone', $data->phone);
        $stmt->bindParam(':email', $data->email);
        $stmt->bindParam(':street', $data->street);
        $stmt->bindParam(':city', $data->city);
        $stmt->bindParam(':is_admin', $data->is_admin);

        $time1 = strtotime($data->created_at);
        $newformat1 = date('Y-m-d', $time1);
        $stmt->bindParam(':created_at', $newformat1);

        $time2 = strtotime($data->updated_at);
        $newformat2 = date('Y-m-d', $time2);
        $stmt->bindParam(':updated_at', $newformat2);

        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (Exception $exc) {
            
        }
        return false;
    }

    public function postPoint($data) {
        $query = 'insert into ' . 'points' .
                ' set customer_id = :customer_id,'
                . 'city = :city,'
                . 'street = :street,'
                . 'place_detail = :place_detail,'
                . 'location = :location,'
                . 'first_name = :first_name,'
                . 'last_name = :last_name,'
                . 'phone = :phone';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':customer_id', $data->customer_id);
        $stmt->bindParam(':city', $data->city);
        $stmt->bindParam(':street', $data->street);
        $stmt->bindParam(':place_detail', $data->place_detail);
        $stmt->bindParam(':location', $data->location);
        $stmt->bindParam(':first_name', $data->first_name);
        $stmt->bindParam(':last_name', $data->last_name);
        $stmt->bindParam(':phone', $data->phone);
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (Exception $exc) {
            
        }
        return false;
    }

    public function postOrder($data) {
        $query = 'insert into ' . 'orders' .
                ' set customer_id = :customer_id,'
                . 'point_id = :point_id,'
                . 'store_id = :store_id,'
                . 'order_status = :order_status,'
                . 'order_date = :order_date,'
                . 'total_price = :total_price';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':customer_id', $data->customer_id);
        $stmt->bindParam(':point_id', $data->point_id);
        $stmt->bindParam(':store_id', $data->store_id);
        $stmt->bindParam(':order_status', $data->order_status);
        $stmt->bindParam(':order_date', $data->order_date);
        $stmt->bindParam(':total_price', $data->total_price);
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (Exception $exc) {
            
        }
        return false;
    }

    public function postOrderItem($data) {
        $query = 'insert into ' . 'order_items' .
                ' set order_id = :order_id,'
                . 'product_id = :product_id,'
                . 'quantity = :quantity,'
                . 'unit_price = :unit_price,'
                . 'total_prices = :total_prices,'
                . 'discount = :discount';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $data->order_id);
        $stmt->bindParam(':product_id', $data->product_id);
        $stmt->bindParam(':quantity', $data->quantity);
        $stmt->bindParam(':unit_price', $data->unit_price);
        $stmt->bindParam(':total_prices', $data->total_prices);
        $stmt->bindParam(':discount', $data->discount);
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (Exception $exc) {
            
        }
        return false;
    }

    public function postStore($data) {
        $name_image = round(microtime(true) * 1000);
        $path_image = "../Big_store/include/images/image-stores/$name_image.png";
        $url_image = "$name_image.png";
        $url_image1 = "http://192.168.1.108/Big_store/include/images/image-stores/$name_image.png";

        $query = 'insert into ' . 'stores' .
                ' set store_name = :store_name,'
                . 'store_describe = :store_describe,'
                . 'phone = :phone,'
                . 'phone_whatsApp = :phone_whatsApp,'
                . 'url_facebook = :url_facebook,'
                . 'url_instegram = :url_instegram,'
                . 'street = :street,'
                . 'city = :city,'
                . 'location = :location,'
                . 'state = :state,'
                . 'image_store = :image_store';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':store_name', $data->store_name);
        $stmt->bindParam(':store_describe', $data->store_describe);
        $stmt->bindParam(':phone', $data->phone);
        $stmt->bindParam(':phone_whatsApp', $data->phone_whatsApp);
        $stmt->bindParam(':url_facebook', $data->url_facebook);
        $stmt->bindParam(':url_instegram', $data->url_instegram);
        $stmt->bindParam(':street', $data->street);
        $stmt->bindParam(':city', $data->city);
        $stmt->bindParam(':location', $data->location);
        $stmt->bindParam(':state', $data->state);
        $stmt->bindParam(':image_store', $url_image1);

        try {
            if ($stmt->execute()) {
                file_put_contents($path_image, base64_decode($data->image_store));
                return true;
            }
        } catch (Exception $exc) {
            
        }
        return false;
    }

    public function postStoreImage($data) {
        $name_image = round(microtime(true) * 1000);
        $path_image = "../Big_store/include/images/image-stores/$name_image.png";
        $url_image = "$name_image.png";
        $url_image1 = "http://192.168.1.108/Big_store/include/images/image-stores/$name_image.png";

        $query = 'insert into ' . 'store_images' .
                ' set store_id = :store_id,'
                . 'name_image = :name_image,'
                . 'path_image = :path_image';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':store_id', $data->store_id);
        $stmt->bindParam(':name_image', $url_image);
        $stmt->bindParam(':path_image', $url_image1);
        try {
            if ($stmt->execute()) {
                file_put_contents($path_image, base64_decode($data->path_image));
                return true;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return false;
    }

    public function postManager() {
        $imge = $_POST['image'];
        $title = $_POST['title'];

        $store_id = $_POST['store_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
        $active = $_POST['active'];

        $path_image = "../Big_store/include/images/image-managers/$title.png";
        $url_image = "$title.png";
        $url_image1 = "http://192.168.1.108/Big_store/include/images/image-managers/$title.png";

        $query = 'insert into ' . 'managers' .
                ' set store_id = :store_id,'
                . 'first_name = :first_name,'
                . 'last_name = :last_name,'
                . 'email = :email,'
                . 'password = :password,'
                . 'phone = :phone,'
                . 'active = :active,'
                . 'personal_picture = :personal_picture';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':store_id', $store_id);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':active', $active);
        $stmt->bindParam(':personal_picture', $url_image1);
        try {
            if ($stmt->execute()) {
                file_put_contents($path_image, base64_decode($imge));
                return true;
            }
        } catch (Exception $exc) {
            
        }
        return false;
    }

    public function postManagerBody($data) {

        $name_image = round(microtime(true) * 1000);
        $path_image = "../Big_store/include/images/image-managers/$name_image.png";
        $url_image = "$name_image.png";
        $url_image1 = "http://localhost/Big_store/include/images/image-managers/$name_image.png";

        $query = 'insert into ' . 'managers' .
                ' set store_id = :store_id,'
                . 'first_name = :first_name,'
                . 'last_name = :last_name,'
                . 'email = :email,'
                . 'password = :password,'
                . 'phone = :phone,'
                . 'active = :active,'
                . 'personal_picture = :personal_picture';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':store_id', $data->store_id);
        $stmt->bindParam(':first_name', $data->first_name);
        $stmt->bindParam(':last_name', $data->last_name);
        $stmt->bindParam(':email', $data->email);
        $stmt->bindParam(':password', $data->password);
        $stmt->bindParam(':phone', $data->phone);
        $stmt->bindParam(':active', $data->active);
        $stmt->bindParam(':personal_picture', $url_image);
        try {
            if ($stmt->execute()) {
                file_put_contents($path_image, base64_decode($data->personal_picture));
                return true;
            }
        } catch (Exception $exc) {
            
        }
        return false;
    }

    public function postStaff($data) {

        $name_image = round(microtime(true) * 1000);
        $path_image = "../Big_store/include/images/image-staffs/$name_image.png";
        $url_image = "$name_image.png";
        $url_image1 = "http://192.168.1.108/Big_store/include/images/image-staffs/$name_image.png";

        $query = 'insert into ' . 'staffs' .
                ' set manager_id = :manager_id,'
                . 'store_id = :store_id,'
                . 'first_name = :first_name,'
                . 'last_name = :last_name,'
                . 'email = :email,'
                . 'password = :password,'
                . 'phone = :phone,'
                . 'active = :active,'
                . 'personal_picture = :personal_picture';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':manager_id', $data->manager_id);
        $stmt->bindParam(':store_id', $data->store_id);
        $stmt->bindParam(':first_name', $data->first_name);
        $stmt->bindParam(':last_name', $data->last_name);
        $stmt->bindParam(':email', $data->email);
        $stmt->bindParam(':password', $data->password);
        $stmt->bindParam(':phone', $data->phone);
        $stmt->bindParam(':active', $data->active);
        $stmt->bindParam(':personal_picture', $url_image1);
        try {
            if ($stmt->execute()) {
                file_put_contents($path_image, base64_decode($data->personal_picture));
                return true;
            }
        } catch (Exception $exc) {
            
        }
        return false;
    }

    public function postCategory($data) {

        $name_image = round(microtime(true) * 1000);
        $path_image = "../Big_store/include/images/icon-categories/$name_image.png";
        $url_image = "$name_image.png";
        $url_image1 = "http://192.168.1.108/Big_store/include/images/icon-categories/$name_image.png";

        $query = 'insert into ' . 'categories' .
                ' set category_name = :category_name,'
                . 'category_icon = :category_icon';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_name', $data->category_name);
        $stmt->bindParam(':category_icon', $url_image1);
        try {
            if ($stmt->execute()) {
                file_put_contents($path_image, base64_decode($data->category_icon));
                return true;
            }
        } catch (Exception $exc) {
            
        }
        return false;
    }

    public function postBrand($data) {

        $name_image = round(microtime(true) * 1000);
        $path_image = "../Big_store/include/images/icon-brands/$name_image.png";
        $url_image = "$name_image.png";
        $url_image1 = "http://192.168.1.108/Big_store/include/images/icon-brands/$name_image.png";

        $query = 'insert into ' . 'brands' .
                ' set brand_name = :brand_name,'
                . 'brand_icon = :brand_icon';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':brand_name', $data->brand_name);
        $stmt->bindParam(':brand_icon', $url_image1);
        try {
            if ($stmt->execute()) {
                file_put_contents($path_image, base64_decode($data->brand_icon));
                return true;
            }
        } catch (Exception $exc) {
            
        }
        return false;
    }

    public function postGroupCategory($data) {

        $name_image = round(microtime(true) * 1000);
        $path_image = "../Big_store/include/images/image-group-category/$name_image.png";
        $url_image = "$name_image.png";
        $url_image1 = "http://192.168.1.108/Big_store/include/images/image-group-category/$name_image.png";

        $query = 'insert into ' . 'groupcategories' .
                ' set category_id = :category_id,'
                . 'name_group_cat = :name_group_cat,'
                . 'group_categories_icon = :group_categories_icon';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $data->category_id);
        $stmt->bindParam(':name_group_cat', $data->name_group_cat);
        $stmt->bindParam(':group_categories_icon', $url_image);

        try {
            if ($stmt->execute()) {
                file_put_contents($path_image, base64_decode($data->group_categories_icon));
                return true;
            }
        } catch (Exception $exc) {
            
        }
        return false;
    }

    public function postSubGroupCategory($data) {
        $query = 'insert into ' . 'subgroupcat' .
                ' set group_cat_id = :group_cat_id,'
                . 'name_sub_group = :name_sub_group';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':group_cat_id', $data->group_cat_id);
        $stmt->bindParam(':name_sub_group', $data->name_sub_group);

        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (Exception $exc) {
            
        }
        return false;
    }

    public function postProduct($data) {
        $name_image = round(microtime(true) * 1000);
        $path_image = "../Big_store/include/images/image-products/$name_image.png";
        $url_image = "$name_image.png";
        $url_image1 = "http://192.168.1.108/Big_store/include/images/image-products/$name_image.png";

        $query = 'insert into ' . 'products' .
                ' set brand_id = :brand_id,'
                . 'store_id = :store_id,'
                . 'sub_group_cat_id = :sub_group_cat_id,'
                . 'product_name = :product_name,'
                . 'product_describe = :product_describe,'
                . 'price = :price,'
                . 'discount = :discount,'
                . 'image_product = :image_product';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':brand_id', $data->brand_id);
        $stmt->bindParam(':store_id', $data->store_id);
        $stmt->bindParam(':sub_group_cat_id', $data->sub_group_cat_id);
        $stmt->bindParam(':product_name', $data->product_name);
        $stmt->bindParam(':product_describe', $data->product_describe);
        $stmt->bindParam(':price', $data->price);
        $stmt->bindParam(':discount', $data->discount);
        $stmt->bindParam(':image_product', $url_image1);

        try {
            if ($stmt->execute()) {
                file_put_contents($path_image, base64_decode($data->image_product));
                return true;
            }
        } catch (Exception $exc) {
            
        }
        return false;
    }

    public function postProductFrontPhotos($data) {
        $path_image = "../Big_store/include/images/image-product-front-photos/$data->title.png";
        $url_image = "$data->title.png";
        $url_image1 = "http://192.168.1.108/Big_store/include/images/image-product-front-photos/$data->title.png";

        $query = 'insert into ' . 'product_front_photos' .
                ' set product_id = :product_id,'
                . 'name_image = :name_image,'
                . 'path_image = :path_image';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $data->product_id);
        $stmt->bindParam(':name_image', $data->title);
        $stmt->bindParam(':path_image', $url_image1);
        try {
            if ($stmt->execute()) {
                file_put_contents($path_image, base64_decode($data->image));
                return true;
            }
        } catch (Exception $exc) {
            
        }
        return false;
    }

    public function postProductDetailedPhotos($data) {
        $path_image = "../Big_store/include/images/image-product-detailed-photos/$data->title.png";
        $url_image = "$data->title.png";
        $url_image1 = "http://192.168.1.108/Big_store/include/images/image-product-detailed-photos/$data->title.png";

        $query = 'insert into ' . 'product_detailed_photos' .
                ' set product_id = :product_id,'
                . 'name_image = :name_image,'
                . 'path_image = :path_image';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $data->product_id);
        $stmt->bindParam(':name_image', $data->title);
        $stmt->bindParam(':path_image', $url_image1);
        try {
            if ($stmt->execute()) {
                file_put_contents($path_image, base64_decode($data->image));
                return true;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        return false;
    }

    public function postProductVariations($data) {
        $query = 'insert into ' . 'products_variations' .
                ' set product_id = :product_id,'
                . 'variation_name = :variation_name';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $data->product_id);
        $stmt->bindParam(':variation_name', $data->variation_name);
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (Exception $exc) {
            
        }
        return false;
    }

    public function postProductVariationOptions($data) {
        $query = 'insert into ' . 'product_variations_options' .
                ' set product_var_id = :product_var_id,'
                . 'variation_option = :variation_option,'
                . 'add_price = :add_price';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_var_id', $data->product_var_id);
        $stmt->bindParam(':variation_option', $data->variation_option);
        $stmt->bindParam(':add_price', $data->add_price);
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (Exception $exc) {
            
        }
        return false;
    }

    public function postRating($data) {
        $query = 'insert into ' . 'ratings' .
                ' set product_id = :product_id,'
                . 'order_id = :order_id,'
                . 'rating = :rating';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $data->product_id);
        $stmt->bindParam(':order_id', $data->order_id);
        $stmt->bindParam(':rating', $data->rating);
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (Exception $exc) {
            
        }
        return false;
    }

    public function postComments($data) {
        $query = 'insert into ' . 'comments' .
                ' set rating_id = :rating_id,'
                . 'comment = :comment';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':rating_id', $data->rating_id);
        $stmt->bindParam(':comment', $data->comment);
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (Exception $exc) {
            
        }
        return false;
    }

}
