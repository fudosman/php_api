<?php
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DATABASE', 'devcomm');

class appStart {
    // create a static property so that when we extend the class
    // we will not need to instantiate the class before we can use it
    // lets also make it a private property
    private static $connect;
    public function connect(){
        // Establish a connection to your database
        // Save it to class property connect
        $connect = new mysqli(HOST, USER, PASS, DATABASE);
        // catch the error and die it
        if($connect->connect_error){
            die('Error connecting to database' . $connect->connect_error);
        }
        // return the connection that was established
        return $connect;
    }
}

class sqlMagic extends appStart {
    // definitions
    public $conn;
    public $sql;
    public $result;

    // use the constructor function to instantiate the connection
    // to the database as extended from appStart
    // save it to the conn property created earlier in the definitions
    public function __construct(){
        $this->conn = $this->connect();
        return $this->conn;
    }

    protected function myquery($sql){
        $this->sql = $sql;
        $this->result = $this->conn->query($this->sql);
        if($this->conn->error){
            die('Error with query '. $this->conn->error);
        }
        return $this->result;
    }

    // simple  C R U D  operations

    // CREATE operation
    public function insert($table, $columns, $values){
        // convert the columns array into comma seperated values and put in a bracket
        $columns = (is_array($columns)) ? implode(',', $columns) : $columns;
        // do same for the values array
        $values = (is_array($values)) ? implode(',', $values) : $values;
        // put the variables in the sql statement variable
        $ran = $this->myquery("INSERT INTO {$table} ({$columns}) VALUES ({$values})");
        // check if successful and return the number of rows inserted into 
        if($ran){return $this->conn->affected_rows;} else return false;
    } 
    public function insert_check($table, $cols, $vals, $where){
		if(empty($where)){ die("Please, define a 'WHERE ..' clause for this operation"); }
		$slct = $this->select($table, $cols, $where);
		if(!$this->result->num_rows){
			return $this->insert($table, $cols, $vals);
		} else {return false;} 
    }
    
    // READ operation
	public function select($table, $cols='', $where='', $orderBy='', $limit=''){
		$sel = "SELECT {$cols} FROM {$table} WHERE {$where} {$orderBy} {$limit}";
		if($this->myquery($sel)){ 
			return $this->result->num_rows; 
		} return FALSE;
    }
    public function select_fetch($table, $cols='', $where='', $orderBy='', $limit=''){
		if($sel = $this->select($table,$cols,$where,$orderBy,$limit)){
			$fetch = array(); 
			$sn = 0;
			while($row = $this->result->fetch_assoc()){	
				$fetch[] = $row;
			} return $fetch;
		} else { return ($sel === 0) ? $sel : FALSE; }
	}
    
    // UPDATE operation
    public function update($table, $colsVals, $where){
		if(empty($where)){ die("Please, define a WHERE clause"); }
		if(empty($colsVals)){ die("Please, specify COLUMN=['VALUE'] set"); }
		$colsVals = (is_array($colsVals)) ? implode(',', $colsVals) : $colsVals; 
		$sqlup = $this->myquery("UPDATE {$table} SET {$colsVals} WHERE {$where}"); 
		if($sqlup){ return $this->conn->affected_rows;} else { return FALSE; } 
    }
    
    // DELETE operation
    // Never delete anything from database
    // Rather update a column to a status value that indicates it's been deleted 
}
?>