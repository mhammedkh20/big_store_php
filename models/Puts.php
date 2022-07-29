<?php

class UpdateDatabase {

    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function putCustomer($data) {
        $query = 'update ' . 'customers' .
                ' set first_name = :first_name,'
                . 'last_name = :last_name,'
                . 'password = :password,'
                . 'phone = :phone,'
                . 'email = :email,'
                . 'street = :street,'
                . 'city = :city,'
                . 'is_admin = :is_admin,'
                . 'created_at = :created_at,'
                . 'updated_at = :updated_at'
                . ' WHERE customer_id = :customer_id';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':first_name', $data->first_name);
        $stmt->bindParam(':last_name', $data->last_name);
        $stmt->bindParam(':password', $data->password);
        $stmt->bindParam(':phone', $data->phone);
        $stmt->bindParam(':email', $data->email);
        $stmt->bindParam(':street', $data->street);
        $stmt->bindParam(':city', $data->city);
        $stmt->bindParam(':is_admin', $data->is_admin);
        $stmt->bindParam(':created_at', $data->created_at);
        $stmt->bindParam(':updated_at', $data->updated_at);
        $stmt->bindParam(':customer_id', $data->customer_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function putPoint($data) {
        $query = 'update ' . 'points' .
                ' set customer_id = :customer_id,'
                . 'city = :city,'
                . 'street = :street,'
                . 'place_detail = :place_detail,'
                . 'location = :location,'
                . 'first_name = :first_name,'
                . 'last_name = :last_name,'
                . 'phone = :phone'
                . ' WHERE point_id = :point_id';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':customer_id', $data->customer_id);
        $stmt->bindParam(':city', $data->city);
        $stmt->bindParam(':street', $data->street);
        $stmt->bindParam(':place_detail', $data->place_detail);
        $stmt->bindParam(':location', $data->location);
        $stmt->bindParam(':first_name', $data->first_name);
        $stmt->bindParam(':last_name', $data->last_name);
        $stmt->bindParam(':phone', $data->phone);
        $stmt->bindParam(':point_id', $data->point_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function putOrder($data) {
        $query = 'update ' . 'orders' .
                ' set customer_id = :customer_id,'
                . 'point_id = :point_id,'
                . 'store_id = :store_id,'
                . 'order_status = :order_status,'
                . 'order_date = :order_date,'
                . 'total_price = :total_price'
                . ' WHERE order_id = :order_id';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':customer_id', $data->customer_id);
        $stmt->bindParam(':point_id', $data->point_id);
        $stmt->bindParam(':store_id', $data->store_id);
        $stmt->bindParam(':order_status', $data->order_status);
        $stmt->bindParam(':order_date', $data->order_date);
        $stmt->bindParam(':total_price', $data->total_price);
        $stmt->bindParam(':order_id', $data->order_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function putOrderItem($data) {
        $query = 'update ' . 'order_items' .
                ' set order_id = :order_id,'
                . 'product_id = :product_id,'
                . 'quantity = :quantity,'
                . 'unit_price = :unit_price,'
                . 'total_prices = :total_prices,'
                . 'discount = :discount'
                . ' WHERE item_id = :item_id';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':order_id', $data->order_id);
        $stmt->bindParam(':product_id', $data->product_id);
        $stmt->bindParam(':quantity', $data->quantity);
        $stmt->bindParam(':unit_price', $data->unit_price);
        $stmt->bindParam(':total_prices', $data->total_prices);
        $stmt->bindParam(':discount', $data->discount);
        $stmt->bindParam(':item_id', $data->item_id);
        try {
            if ($stmt->execute()) {
                return true;
            }
        } catch (Exception $exc) {
            
        }
        return false;
    }

    public function putStore($data) {
        $name_image = round(microtime(true) * 1000);
        $path_image = "../Big_store/include/images/image-stores/$name_image.png";
        $url_image = "$name_image.png";
        $url_image1 = "http://localhost/Big_store/include/images/image-stores/$name_image.png";

        $query = 'update ' . 'stores' .
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
                . 'image_store = :image_store'
                . ' WHERE store_id = :store_id';
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
        $stmt->bindParam(':image_store', $url_image);
        $stmt->bindParam(':store_id', $data->store_id);
        try {
            if ($stmt->execute()) {
                file_put_contents($path_image, base64_decode($data->image_store));
                $path_image = "../Big_store/include/images/image-stores/$data->old_image";
                @unlink($path_image);
                return true;
            }
        } catch (Exception $exc) {
            
        }
        return false;
    }

    public function putManager($data) {
        $name_image = round(microtime(true) * 1000);
        $path_image = "../Big_store/include/images/image-managers/$name_image.png";
        $url_image = "$name_image.png";
        $url_image1 = "http://localhost/Big_store/include/images/image-managers/$name_image.png";

        $query = 'update ' . 'managers' .
                ' set store_id = :store_id,'
                . 'first_name = :first_name,'
                . 'last_name = :last_name,'
                . 'email = :email,'
                . 'password = :password,'
                . 'phone = :phone,'
                . 'active = :active,'
                . 'personal_picture = :personal_picture'
                . ' WHERE manager_id = :manager_id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':store_id', $data->store_id);
        $stmt->bindParam(':first_name', $data->first_name);
        $stmt->bindParam(':last_name', $data->last_name);
        $stmt->bindParam(':email', $data->email);
        $stmt->bindParam(':password', $data->password);
        $stmt->bindParam(':phone', $data->phone);
        $stmt->bindParam(':active', $data->active);
        $stmt->bindParam(':personal_picture', $url_image);
        $stmt->bindParam(':manager_id', $data->manager_id);

        if ($stmt->execute()) {
            file_put_contents($path_image, base64_decode($data->personal_picture));
            $path_image = "../Big_store/include/images/image-managers/$data->old_image";
            @unlink($path_image);
            return true;
        }
        return false;
    }

    public function putStaff($data) {

        $name_image = round(microtime(true) * 1000);
        $path_image = "../Big_store/include/images/image-staffs/$name_image.png";
        $url_image = "$name_image.png";
        $url_image1 = "http://localhost/Big_store/include/images/image-staffs/$name_image.png";

        $query = 'update ' . 'staffs' .
                ' set manager_id = :manager_id,'
                . 'store_id = :store_id,'
                . 'first_name = :first_name,'
                . 'last_name = :last_name,'
                . 'email = :email,'
                . 'password = :password,'
                . 'phone = :phone,'
                . 'active = :active,'
                . 'personal_picture = :personal_picture'
                . ' WHERE staff_id = :staff_id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':store_id', $data->store_id);
        $stmt->bindParam(':first_name', $data->first_name);
        $stmt->bindParam(':last_name', $data->last_name);
        $stmt->bindParam(':email', $data->email);
        $stmt->bindParam(':password', $data->password);
        $stmt->bindParam(':phone', $data->phone);
        $stmt->bindParam(':active', $data->active);
        $stmt->bindParam(':personal_picture', $url_image);
        $stmt->bindParam(':staff_id', $data->staff_id);

        if ($stmt->execute()) {
            file_put_contents($path_image, base64_decode($data->personal_picture));
            $path_image = "../Big_store/include/images/image-staffs/$data->old_image";
            @unlink($path_image);
            return true;
        }
        return false;
    }

    public function putCategory($data) {
        $name_image = round(microtime(true) * 1000);
        $path_image = "../Big_store/include/images/icon-categories/$name_image.png";
        $url_image = "$name_image.png";
        $url_image1 = "http://localhost/Big_store/include/images/icon-categories/$name_image.png";

        $query = 'update ' . 'categories' .
                ' set category_name = :category_name,'
                . 'category_icon = :category_icon'
                . ' WHERE category_id = :category_id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_name', $data->category_name);
        $stmt->bindParam(':category_icon', $url_image);
        $stmt->bindParam(':category_id', $data->category_id);

        if ($stmt->execute()) {
            file_put_contents($path_image, base64_decode($data->category_icon));
            $path_image = "../Big_store/include/images/icon-categories/$data->old_image";
            @unlink($path_image);
            return true;
        }
        return false;
    }

    public function putBrand($data) {
        $name_image = round(microtime(true) * 1000);
        $path_image = "../Big_store/include/images/icon-brands/$name_image.png";
        $url_image = "$name_image.png";
        $url_image1 = "http://localhost/Big_store/include/images/icon-brands/$name_image.png";

        $query = 'update ' . 'brands' .
                ' set brand_name = :brand_name,'
                . 'brand_icon = :brand_icon'
                . ' WHERE brand_id = :brand_id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':brand_name', $data->brand_name);
        $stmt->bindParam(':brand_icon', $url_image);
        $stmt->bindParam(':brand_id', $data->brand_id);

        if ($stmt->execute()) {
            file_put_contents($path_image, base64_decode($data->brand_icon));
            $path_image = "../Big_store/include/images/icon-brands/$data->old_image";
            @unlink($path_image);
            return true;
        }
        return false;
    }

    public function putGroupCategory($data) {
        $name_image = round(microtime(true) * 1000);
        $path_image = "../Big_store/include/images/image-group-category/$name_image.png";
        $url_image = "$name_image.png";
        $url_image1 = "http://localhost/Big_store/include/images/image-group-category/$name_image.png";

        $query = 'update ' . 'groupcategories' .
                ' set category_id = :category_id,'
                . 'name_group_cat = :name_group_cat,'
                . 'group_categories_icon = :group_categories_icon'
                . ' WHERE group_cat_id = :group_cat_id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $data->category_id);
        $stmt->bindParam(':name_group_cat', $data->name_group_cat);
        $stmt->bindParam(':group_categories_icon', $url_image);
        $stmt->bindParam(':group_cat_id', $data->group_cat_id);

        if ($stmt->execute()) {
            file_put_contents($path_image, base64_decode($data->group_categories_icon));
            $path_image = "../Big_store/include/images/image-group-category/$data->old_image";
            @unlink($path_image);
            return true;
        }
        return false;
    }

    public function putSubGroupCategory($data) {
        $query = 'update ' . 'subgroupcat' .
                ' set group_cat_id = :group_cat_id,'
                . 'name_sub_group = :name_sub_group'
                . ' WHERE sub_group_cat_id = :sub_group_cat_id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':group_cat_id', $data->group_cat_id);
        $stmt->bindParam(':name_sub_group', $data->name_sub_group);
        $stmt->bindParam(':sub_group_cat_id', $data->sub_group_cat_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function putProduct($data) {
        $name_image = round(microtime(true) * 1000);
        $path_image = "../Big_store/include/images/image-products/$name_image.png";
        $url_image = "$name_image.png";
        $url_image1 = "http://localhost/Big_store/include/images/image-products/$name_image.png";

        $query = 'update ' . 'products' .
                ' set brand_id = :brand_id,'
                . 'store_id = :store_id,'
                . 'sub_group_cat_id = :sub_group_cat_id,'
                . 'product_name = :product_name,'
                . 'product_describe = :product_describe,'
                . 'price = :price,'
                . 'discount = :discount,'
                . 'image_product = :image_product'
                . ' WHERE product_id = :product_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':brand_id', $data->brand_id);
        $stmt->bindParam(':store_id', $data->store_id);
        $stmt->bindParam(':sub_group_cat_id', $data->sub_group_cat_id);
        $stmt->bindParam(':product_name', $data->product_name);
        $stmt->bindParam(':product_describe', $data->product_describe);
        $stmt->bindParam(':price', $data->price);
        $stmt->bindParam(':discount', $data->discount);
        $stmt->bindParam(':image_product', $url_image);
        $stmt->bindParam(':product_id', $data->product_id);

        if ($stmt->execute()) {
            file_put_contents($path_image, base64_decode($data->image_product));
            $path_image = "../Big_store/include/images/icon-categories/$data->old_image";
            @unlink($path_image);
            return true;
        }
        return false;
    }

    public function putProductVariations($data) {
        $query = 'update ' . 'products_variations' .
                ' set product_id = :product_id,'
                . 'variation_name = :variation_name'
                . ' WHERE product_var_id = :product_var_id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $data->product_id);
        $stmt->bindParam(':variation_name', $data->variation_name);
        $stmt->bindParam(':product_var_id', $data->product_var_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function putProductVariationOptions($data) {
        $query = 'update ' . 'product_variations_options' .
                ' set product_var_id = :product_var_id,'
                . 'variation_option = :variation_option,'
                . 'add_price = :add_price'
                . ' WHERE pro_vari_option_id = :pro_vari_option_id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_var_id', $data->product_var_id);
        $stmt->bindParam(':variation_option', $data->variation_option);
        $stmt->bindParam(':add_price', $data->add_price);
        $stmt->bindParam(':pro_vari_option_id', $data->pro_vari_option_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function putRating($data) {
        $query = 'update ' . 'ratings' .
                ' set product_id = :product_id,'
                . 'order_id = :order_id,'
                . 'rating = :rating'
                . ' WHERE rating_id = :rating_id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':product_id', $data->product_id);
        $stmt->bindParam(':order_id', $data->order_id);
        $stmt->bindParam(':rating', $data->rating);
        $stmt->bindParam(':rating_id', $data->rating_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function putComments($data) {
        $query = 'update ' . 'comments' .
                ' set rating_id = :rating_id,'
                . 'comment = :comment'
                . ' WHERE comment_id = :comment_id';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':rating_id', $data->rating_id);
        $stmt->bindParam(':comment', $data->comment);
        $stmt->bindParam(':comment_id', $data->comment_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

}
