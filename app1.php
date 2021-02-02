<?php
include_once('sql1.php');

// The methods that concerns the app in question we are building
// For instance we are making a simple ecommerce app
// Before you start write down you process flow
// This will be a guide to use in creating your methods 
class EcommerceApp extends sqlMagic {
    public $sql;
    // the constructor instantiates the sqlMagic and returns the connection
    public function __construct(){
        $this->sql = new sqlMagic();
        return $this->sql;
    }

    // fetch and display all the products in the db that has status of 1
    // Here we are using the select methods created in our sql operations
    public function getProducts(){
        $table = "products";
        $cols = "*";
        // status 1 = published, status 2 = unpublished
        $where = "`status` = '1'";
        $products = $this->sql->select($table, $cols, $where);
        if($products > 0){
            return $this->sql->select_fetch($table, $cols, $where);
        } else {return false;}
    }

    public function adminAddProduct($name, $desc, $price, $image, $quan, $owner){
        $pid = rand(100000, 999999);
        $stat = "2";
        $cat = date('Y-m-d H:i:s');
        $table = "products";
        $cols = "`product_name`, `product_desc`, `product_price`, `product_image`, `product_quan`, `product_id`, `owner_id`, `status`, `created_at`";
        $vals = "'$name','$desc','$price','$image','$quan','$pid','$owner','$stat','$cat'";
        $where = "`product_id` = '$pid'";
        $inserted = $this->sql->insert_check($table, $cols, $vals, $where);
        if($inserted){return true;} else {return false;}
    }
    public function adminGetProducts(){
        $table = "products";
        $cols = "*";
        // status 1 = published, status 2 = unpublished
        $where = "`status` = '1' OR `status` = '2'";
        $products = $this->sql->select($table, $cols, $where);
        if($products > 0){
            return $this->sql->select_fetch($table, $cols, $where);
        } else {return false;}
    }
    public function adminUpdateProduct($name, $desc, $price, $quan, $pid){
        $updat = date('Y-m-d H:i:s');
        $table = "products";
        $colVals = "`product_name` = '$name', `product_desc` = '$desc', `product_price` = '$price', `product_quan` ='$quan', `updated_at`='$updat'";
        // status 1 = published, status 2 = unpublished
        $where = "`product_id` = '$pid' AND `status` = '2'";
        $updated = $this->sql->update($table, $colVals, $where);
        if($updated){return true;} else {return false;}
    }
    public function adminPublishProduct($pid){
        $updat = date('Y-m-d H:i:s');
        $table = "products";
        $colVals = "`status` = '1', `updated_at`='$updat'";
        // status 1 = published, status 2 = unpublished
        $where = "`product_id` = '$pid' AND `status` = '2'";
        $updated = $this->sql->update($table, $colVals, $where);
        if($updated){return true;} else {return false;}
    }
    public function adminUnpublishProduct($pid){
        $updat = date('Y-m-d H:i:s');
        $table = "products";
        $colVals = "`status` = '2', `updated_at`='$updat'";
        // status 1 = published, status 2 = unpublished
        $where = "`product_id` = '$pid' AND `status` = '1'";
        $updated = $this->sql->update($table, $colVals, $where);
        if($updated){return true;} else {return false;}
    }
    public function adminGetUsers(){
        $table = "users";
        $cols = "*";
        // status 1 = active, status 2 = delisted
        $where = "`status` = '1' OR `status` = '2'";
        $users = $this->sql->select($table, $cols, $where);
        if($users > 0){
            return $this->sql->select_fetch($table, $cols, $where);
        } else {return false;}
    }
    public function adminGetOrders(){
        $table = "orders";
        $cols = "*";
        // status 1 = not delivered, status 2 = delivered
        $where = "`status` = '1' OR `status` = '2'";
        $orders = $this->sql->select($table, $cols, $where);
        if($orders > 0){
            return $this->sql->select_fetch($table, $cols, $where);
        } else {return false;}
    }
    public function adminClearOrder($oid){
        $updat = date('Y-m-d H:i:s');
        $table = "orders";
        $colVals = "`status` = '2', `delivered_at`='$updat'";
        // status 1 = not delivered, status 2 = delivered
        $where = "`order_id` = '$oid' AND `status` = '1'";
        $deliver = $this->sql->update($table, $colVals, $where);
        if($deliver){return true;} else {return false;}
    }


    // *************************************** 
    // ************** U S E R S **************
    // ***************************************
    public function isEmailRegistered($email){
        $table = "users"; 
        $cols = "*";
        $where = "`user_email` = '$email'";
        if($this->sql->select_fetch($table,$cols,$where)){
        return TRUE;} else {return FALSE;}
    }
    public function isEmailPasswordMatch($email, $pass){
        $table = "users"; $cols = "*"; 
        $ps = sha1(md5($pass));
        $orderby = "ORDER BY `id` ASC";
        $limit = "LIMIT 1";
        $where = "`user_email` = '$email' AND `user_pass`='".trim($ps)."'";
        if($fet = $this->sql->select_fetch($table,$cols,$where,$orderby,$limit)){
        return $fet;} else {return FALSE;}
    }
    public function userSignUp($email, $phone, $pass){
        $uuid = rand(100000, 999999);
        $stat = "1"; // status 1 = active, status 2 = delisted
        $reg = date('Y-m-d H:i:s');
        $table = "users"; $pass = sha1(md5($pass));
        $cols = "`user_email`,`user_phone`,`user_pass`,`user_uuid`,`user_hash`,`reg_time`";
        $vals = "'$email','$phone','$pass','$uuid','$stat','$reg'";
        $where = "`user_uuid` = '$uuid' OR `user_email` = '$email'";
        $created = $this->sql->insert_check($table, $cols, $vals, $where);
        if($created){return true;} else {return false;}
    }
    public function createProduct($name,$price,$desc,$quantity,$userid){
        $product_id = rand(100000, 999999);
        $stat = "1"; // status 1 = active, status 2 = delisted
        $reg = date('Y-m-d H:i:s');
        $table = "products";
        $cols = "`product_name`,`product_price`,`product_desc`,`product_quan`,`owner_id`,`product_id`,`status`,`created_at`";
        $vals = "'$name','$price','$desc','$quantity','$userid','$product_id','$stat','$reg'";
        $where = "`product_name` = '$name'";
        $created = $this->sql->insert_check($table, $cols, $vals, $where);
        if($created){return true;} else {return false;}
    }
    public function getAllProducts(){
        $table = "products";
        $cols = "*";
        // status 1 = active, status 2 = delisted
        $where = "`status` = '1'";
        $users = $this->sql->select($table, $cols, $where);
        if($users > 0){
            return $this->sql->select_fetch($table, $cols, $where);
        } else {return false;}
    }


}

?>