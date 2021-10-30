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

$user->username = isset($_GET["username"]) ? $_GET["username"] : die();

$user->password = isset($_GET["password"]) ? $_GET["password"] : die();

$result = $user->login();
$num = $result->rowCount();

//check if more than zero users found
if($num > 0){
//get the retrieved row
$row = $result->fetch(PDO::FETCH_ASSOC);

extract($row);

//create the array
$user_arr = array("message" => "Login Successfull!",
"username" =>$username,
"member_id" =>$member_id);

//set response code - 200 OK
http_response_code(200);
//Turn to JSON and output (show users data in JSON format)
echo json_encode($user_arr);

}else{
//set response code - 404 Not found
http_response_code(404);
//tell the user no Users found
echo json_encode(array("message"=>"Login Failed")
);
}