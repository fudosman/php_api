<?php
// all origins are allowed access to the endpoint
header("Access-Control-Allow-Origin: *");
// all methods are allowed on this endpoint
header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-headers, access-control-allow-origin, access-control-allow-methods');
// all inputs must be in json format
header("Content-Type: application/json; charset=UTF-8");
// connect to the app file
require_once __DIR__ . '/app1.php';
// instantiate the class
$app = new EcommerceApp();
// request variable contains all json input received from the front end
$request = json_decode(file_get_contents('php://input'), TRUE);

// check if PHP detected any json error, proceed if none
if (json_last_error() === JSON_ERROR_NONE) {

    // this is an array of all the allowed keys
    // we will use to differentiate the operations
    $arr = ['GHTSYGDHSFDOIUG', '5buy9n4867ybn59', 'APS', 'FAPS'];
    // if a key sent alongside with a request does not match
    // reject the request and send back a message
    if (in_array($request['key'], $arr)) {
        
        // default response code, default response data
        $code = null; $data = null; $result;

        // login api, the key for login is LOG
        // this key must be in the arr array above
        if($request['key'] == 'GHTSYGDHSFDOIUG'){
            $email = trim(strtolower($request['email']));
            $pass = $request['password'];
            $match = $app->isEmailPasswordMatch($email, $pass);
            if($match > 0){
                $code = '00'; // means success
                $data = array(
                    'phone' => $match[0]["user_phone"], 
                    'email' => $match[0]["user_email"],   
                    'userid' => $match[0]["user_uuid"],
                    'message' => "Login Successful");
            } else {
                $code = '01'; // means fail 
                $data = 'Login Failed!'; // the response data
            }
        } 

        // signup api
        if($request['key'] == '5buy9n4867ybn59'){                         
            $phone = $request['phone'];
            $email = $request['email'];                      
            $pass = $request['password'];
            $res = $app->isEmailRegistered($email);
            if($phone && $email && $pass !== ""){
                if($res === FALSE){
                    if($app->userSignUp($email,$phone,$pass)){
                        $code = '00'; $data = 'Sign Up Successful!';
                    } else {$code = '01'; $data = 'Sign Up Failed';}    
                } else {$code = '01'; $data = 'This Email is Registered!';}
            } else {$code = '01'; $data = 'Please fill ALL fields!';}
        } 
    //     // get products
        if($request['key'] == 'FAPS'){
            if($items = $app->getAllProducts()){
                $code = '00'; $data = $items;
            } else {$code = '01'; $data = 'No product found!';}
        } 
    //     // get product categories
    //     if($request['key'] == 'FPC'){
    //         if($items = $fxn->getCategories()){
    //             $code = '00'; $data = $items;
    //         } else {$code = '01'; $data = 'No category found!';}
    //     } 
        // add product
        if($request['key'] == "APS"){
            $name = trim(ucwords($request['name']));
            $price = $request['price'];
            $desc = $request['description'];
            $quantity = $request['quantity'];
            $userid = $request['userid'];

            
            if($items = $app->createProduct($name,$price,$desc,$quantity,$userid)){
                $code = '00'; $data = 'Product Added Successfully!';
            } else {$code = '01'; $data = 'Product Added Failed!';}
        } 
    //     // get orders
    //     if($request['key'] == 'POS'){
    //         $userid = $request['userid'];
    //         if($items = $fxn->getOrders($userid)){
    //             $code = '00'; $data = $items;
    //         } else {$code = '01'; $data = 'No orders found!';}
    //     } 
    //     // create order
    //     if($request['key'] == 'COS'){
    //         $name = trim(ucwords($request['name']));
    //         $email = trim(strtolower($request['email']));
    //         $address = trim(ucwords($request['address']));
    //         $items = $request['cartItems'];
    //         $total = $request['total'];
    //         if($done = $fxn->createOrders($name,$email,$address,$items,$total)){
    //             $code = '00'; $data = "Order created successfully!";
    //         } else {$code = '01'; $data = 'Order creation failed!';}
    //     } 
        





        echo json_encode(['code'=> $code, 'data' => $data]);
    } else {echo 'wrong or empty key';}
} else {echo "Request is not JSON";}
?> 