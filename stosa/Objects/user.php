<?php
class User {
    private $conn;
    private $table = "users";

    //object properties
    public $id;
    public $username;
    public $email;
    public $password;

    //Constructor with the database
    public function __construct($db){
        $this->conn = $db;
    }

    //Get users (read)
    public function read(){
        //create query using aliases
        $query = "SELECT
        p.id,         
        p.username,
        p.email,
        p.password
        FROM
        " . $this->table . " p
        ORDER BY
        p.id DESC";

        //prepare query statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        return $stmt;
    }

}
?>