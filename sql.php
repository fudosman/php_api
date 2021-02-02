<?php
/*
// $host = "localhost";
// $user = "root";
// $password = "";
// $db = "devcomm";


// Takes in 3-4 parameters
// HOST, USER, PASSWORD, DATABASE

// $dbconnect = new mysqli($host, $user, $password, $db);

// Lets check if a connection was established

// if($dbconnect){
    
    //     $sql = $dbconnect->query("CREATE DATABASE  devcomm");
    //     if ($sql){
        //     echo "Created DB";
        //     } else{
            //     echo "could not create DB";
            //     }
            // } else {   
                //     echo "could not connect";
                
                
                // CREATING A TABLE
//      if($dbconnect){
                    
//             $sql = $dbconnect->query("CREATE TABLE `users` (
//             id int(2) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
//             user_email VARCHAR(255) NOT NULL,
//             user_phone VARCHAR(11) NOT NULL,
//             first_name VARCHAR(455) NOT NULL,
//             last_name VARCHAR(455) NOT NULL,
//             user_address VARCHAR(455) NOT NULL,
//             user_uuid int(11) NOT NULL,
//             user_hash VARCHAR (255) NOT NULL
//         )");
//         if ($sql){
//             echo "Created DB";
//         } else{
//         echo "could not create DB";
//         }
// } else {   
//     echo "could not connect";
// }


// USed for Inserting DATA in your DATABASE
// if ($dbconnect){
//     $sql = $dbconnect->query( "INSERT INTO `users`(
//         `user_email`,
//         `user_phone`,
//         `first_name`,
//         `last_name`,
//         `user_address`,
//         `user_uuid`,
//         `user_hash`)
//     VALUES(
//         'wilson.onochie@gmail.com',
//         '09055559994',
//         'Wilson',
//         'Onochie',
//         'Awka',
//         '65768789',
//         'jsshjdndnddjdffkfkfk'
// )");


// For Selecting User in DATABASE
// if ($dbConnect){
//     $sql = $dbconnect->query("SELECT * FROM `users`");
//     if($sql){
//         for ($i = 0; $i< $sql->num_rows;$i++){
//             $items = mysqli_fetch_object($sql);
//             foreach($items as $keys => $values){
//                 echo "<td". $keys. "</td><td>". $value . '</td><br>';
//             }
//         }
    
//     }else{
//         echo "could not find anything in Table";
//     }
// }else {
//     echo "could not connect to DB ";
// }

// Used for Deleting from DATABASE
// if ($dbConnect){
//         $sql = $dbconnect->query("DELETE  FROM `users`");
//         if($sql){
//             echo "Deleted the data";
//         }else{
//             echo "could not find anything in Table";
//         }
//     }else {
//         echo "could not connect to DB ";
//     }
*/

define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DATABASE', 'devcomm');

class appStart{
    private static $connect;
    public function connect(){
        $connect = new mysqli(HOST, USER, PASS, DATABASE);
        if($connect-> connect_error){
            die('Error connecting to database'.$connect->connect_error);
            return $connect;
        }
    }

 class sqlMagic extends appStart{
    // definitions
    public  $conn;
    public $sql;
    public $result;

    // use the constructor function o instantiate the connection 
    // to the database as extended from appStart
    // save it to the conn property created earlier in the definitions
    public function_construct(){
        $this->conn = $this->connect();
        return $this-> conn;
    }

    // protected function can only be used inside its method
    protected function myquery($sql){
        $this->sql = $sql;
        $this->result = $this->conn->query($this.sql);
        if($this->conn->error){
            die('Error with query' . $this->conn->error);

        }

        return $this->result;
    }

    // C R U D operations
    public function create(){
        $sql = "INSERT INTO `users` ";


    }
    public function Read(){

    }
    public function Update(){

    }
    public function Delete(){

    }

    

 }


?>