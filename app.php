<?php

include_once ('sql1.php');

// Th methods that concern the app in question we are building 
// For instance we are making  simple ecommerce app
// Before you start write down your proccess flow
// This will be a uide to use in creating your methods

class EcommerceApp extends sqlMagic{

    public $conn;

    public function ____construct(){
        $this->conn = new sqlMagic();
        return $this->conn;

    }

// fetch and display all the products in the db that status of 1
// Here we are using the select methods created in our sql operations
    public function getProducts(){

    $table = "products";
    $cols = "*";
    // status 1 = published , status 2 = unpublished
    $where = "status ` = '1' ";
    $products = $this->sql->select ($table, $cols, $where);
    if($products > 0){
        return $this->sql->select_fetch($table, $cols, $where);
    } else {return false;}
    
}




?>