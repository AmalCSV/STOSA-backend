<?php
//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//include database and object files
include_once "../config/database.php";
include_once "../Objects/user.php";

//instantiate database and connect
$database = new Database();
$db = $database->connection();

//initialize object
$user = new User($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->username) &&
    !empty($data->email) &&
    !empty($data->password)
) {
//set(assign) user property values
$user->username = $data->username;
$user->email = $data->email;
$user->password = $data->password;

//create user
if($user->create()){
    //set response code -201 created
    http_response_code(201);

    // tell the user
    echo json_encode(array("message" => "Product was created."));
}

else{
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create product."));
}
}
?>