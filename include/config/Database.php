<?php

class Database{
    private $host = 'localhost';
    private $db_name = 'db_ecommerce_database';
    private $username = 'root';
    private $password = '';
    private $conn;
    
    public function connect(){
        $this->conn=null;
        try {
            
            $this->conn=new PDO('mysql:host='.$this->host.';dbname='.$this->db_name, 
                    $this->username, $this->password,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch (PDOException $exc) {
            echo 'Connection Error: '.$exc->getMessage();
        }
        return $this->conn;
    }
    
}