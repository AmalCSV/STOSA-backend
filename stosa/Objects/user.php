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

    public function read_single(){
        //creating the query
        $query = "SELECT
        p.id,
        p.username,
        p.email,
        p.password
        FROM
        " . $this->table . " p
        WHERE
        p.id = ?
        LIMIT 0,1"; // ? - Bind parameter (placeholder)

    //prepare the query statement
    $stmt = $this->conn->prepare($query);
    
    //Bind parameter
    $stmt->bindParam(1, $this->id); //1st parameter binded to this id.

    //execute query
    $stmt->execute();

    $row =$stmt->fetch(PDO::FETCH_ASSOC);

    //set values to object properties
    $this->username = $row['username'];
    $this->email = $row['email'];
    $this->password= $row['password'];

}

public function create(){
    $query = "INSERT INTO " . $this->table . "
    SET
    username = :username, 
    email = :email,
    password = :password"; // named parameters (to define these later)

//prepare query
$stmt = $this->conn->prepare($query);

//sanitize data(clean up for security)
$this->username = htmlspecialchars(strip_tags($this->username));
$this->email = htmlspecialchars(strip_tags($this->email));
$this->password = htmlspecialchars(strip_tags($this->password));

//bind the data
$stmt->bindparam(":username", $this->username);
$stmt->bindparam(":email",$this->email);
$stmt->bindparam(":password",$this->password);

//Execute query
if($stmt->execute()){
    return true;
}else{
    return false;
}
}
public function update(){
    $query = "UPDATE " . $this->table . "
   SET
    username = :username, 
    email = :email,
    password = :password
   WHERE
    id = :id"; // named parameters (to define these later)

//prepare query
$stmt = $this->conn->prepare($query);

//sanitize data(clean up for security)
$this->username = htmlspecialchars(strip_tags($this->username));
$this->email = htmlspecialchars(strip_tags($this->email));
$this->password = htmlspecialchars(strip_tags($this->password));
$this->id = htmlspecialchars(strip_tags($this->id));

//bind the data
$stmt->bindparam(":username", $this->username);
$stmt->bindparam(":email",$this->email);
$stmt->bindparam(":password",$this->password);
$stmt->bindparam(":id",$this->id);

//Execute query
if($stmt->execute()){
    return true;
}else{
    return false;
}

}

Public function delete(){
    //create query
    $query = "DELETE FROM " . $this->table . " WHERE id=:id";

    //prepare query
    $stmt = $this->conn->prepare($query);

    //sanitize
    $this->id = htmlspecialchars(strip_tags($this->id));

    //bind
    $stmt->bindparam(":id",$this->id);

    //Execute query
if($stmt->execute()){
    return true;
}else{
    return false;
}
}
}
?>