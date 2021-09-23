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

//query products
$result = $user->read();
$num = $result->rowCount();

//check if more than zero users found
if($num > 0){
//user array
$users_arr = array();
$users_arr["data"] = array(); //?

while($row = $result->fetch(PDO::FETCH_ASSOC)){
     extract($row);

     $user_record = array(
         "id" => $id,
         "username" =>$username,
         "email" =>$email,
         "password" =>$password
     );

     //push to data
     array_push($users_arr["data"], $user_record);
}

//set response code - 200 OK
http_response_code(200);
//Turn to JSON and output (show users data in JSON format)
echo json_encode($users_arr);

}else{
//set response code - 404 Not found
http_response_code(404);
//tell the user no Users found
echo json_encode(array("message"=>"No Users Found")
);

}
?>