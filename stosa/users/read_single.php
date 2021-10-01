<?php
//headers
header("Acess-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//include database and object files
include_once "../config/database.php";
include_once "../Objects/user.php";

//instantiate database and connect
$database = new Database();
$db = $database->connection();

//initialize object
$user = new User($db);

//Get ID from the URL
$user->id = isset($_GET["id"]) ? $_GET["id"] : die(); //isset- checks to c if sumthing is set. ?-then get it. :-else die

//Get Post
$user->read_single();

//create array
$user_arr = array(
    "id" => $user->id,
    "username" => $user->username,
    "email" => $user->email,
    "password" => $user->password
);

//make JSON
//set response code - 200 OK
if($user->username!=null){
http_response_code(200);

//make it json format
echo json_encode($user_arr);
}
else{
    http_response_code(404);
    echo json_encode(array("message"=>"Product Not Found"));
}
?>