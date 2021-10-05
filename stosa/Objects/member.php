<?php
class Member {
    //database connection and table name
    private $conn;
    private $table = "member";

    //object properties
    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $addressLine;
    public $city;

    //constructor with the database
    public function __construct($db){
        $this->conn = $db;
    }

    public function read(){
        //set query
        $query = "SELECT
        id,
        firstName,
        lastName,
        email,
        addressLine,
        city
         FROM " . $this->table . "
         ORDER BY
         id DESC";
         
         //prepare the query statement
         $stmt = $this->conn->prepare($query);

         //execute the query statement
         $stmt->execute();

         return $stmt;

    }

    public function read_single(){
        //set query
    $query = "SELECT
        id,
        firstName,
        lastName,
        email,
        addressLine,
        city 
    FROM " . $this->table . "
    WHERE id = ?
    LIMIT 0,1"; // placeholder (posiional parameters) to bindparam

    //prepare statement
    $stmt = $this->conn->prepare($query);
    
    //Bind ID
    $stmt->bindParam(1, $this->id); //1st parameter should bind to this id.

    //Execute query
    $stmt->execute();
    
    //get row array
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //Set properties to returned
    $this->firstName = $row['firstName'];
    $this->lastName = $row['lastName'];
    $this->email = $row['email'];
    $this->addressLine = $row['addressLine'];
    $this->city = $row['city'];

    }

    public function create(){
        //set query
        $query = "INSERT INTO
        " . $this->table . "
        SET
        firstName = :firstName,
        lastName = :lastName,
        email = :email,
        addressLine = :addressLine,
        city = :city"; //named paramaeters

        //prepare the query
        $stmt = $this->conn->prepare($query);

        //sanitize the data
        $this->firstName = htmlspecialchars(strip_tags($this->firstName));
        $this->lastName = htmlspecialchars(strip_tags($this->lastName));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->addressLine = htmlspecialchars(strip_tags($this->addressLine));
        $this->city = htmlspecialchars(strip_tags($this->city));

        //bind the data
        $stmt->bindparam(":firstName", $this->firstName);
        $stmt->bindparam(":lastName", $this->lastName);
        $stmt->bindparam(":email", $this->email);
        $stmt->bindparam(":addressLine", $this->addressLine);
        $stmt->bindparam(":city", $this->city);
        
        //execute the query
        if($stmt->execute()){
            return true;
        }
        return false;
    }


}