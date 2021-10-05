<?php
//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database and object files
include_once "../config/database.php";
include_once "../Objects/member.php";

//instantiate database and connect
$database = new Database();
$db = $database->connection();

//initialize object
$member = new Member($db);

//Turnary operation
//Get id from url
$member->id = isset($_GET["id"]) ? $_GET["id"] : die();

//Get Member
$member->read_single();

//Create array
$member_arr = array (
    "id" => $member->id,
    "fistName" => $member->firstName,
    "lastName" => $member->lastName,
    "email" => $member->email,
    "addressLine" => $member->addressLine,
    "city" => $member->city
);

if($member->firstName!=null){
//set response code - 200 OK
http_response_code(200);
//Turn to JSON and output (show members data in JSON format)
echo json_encode($member_arr);
}else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user product does not exist
    echo json_encode(array("message" => "Member does not exist."));
}