<?php
//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//include database and object files
include_once "../config/database.php";
include_once "../Objects/member.php";

//instantiate database and connect
$database = new Database();
$db = $database->connection();

//initialize object
$member = new Member($db);

//get raw posted data
$data = json_decode(file_get_contents("php://input"));

//set member property values to data
$member->firstName = $data->firstName;
$member->lastName = $data->lastName;
$member->email = $data->email;
$member->addressLine = $data->addressLine;
$member->city = $data->city;

if($member->create()){
    //set response code -201 created
    http_response_code(201);

    // tell the user
    echo json_encode(array("message" => "Member was created."));
}

else{
    // set response code - 503 service unavailable
    http_response_code(503);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create Member."));
}

