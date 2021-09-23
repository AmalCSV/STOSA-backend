<?php
class Database{
    //your own DB parameters
    private $host = "localhost";
    private $db_name = "stosa";
    private $username = "root";
    private $password = "";
    public $conn;

    //create a method to connect (DB connect)
    public function connection(){
        $this->conn = null; //when you want to access any of the properties from class use $this->

        //create a new PDO object

        try{
            $this->conn = new PDO ("mysql:host=" . $this->host . ";dbname=" . $this->db_name , $this->username , $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        }catch(PDOException $exception){
            echo "Connection Error: " . $exception->getMessage();

        }

        return $this->conn;

    }
}

?>