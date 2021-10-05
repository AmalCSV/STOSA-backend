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

//query members
$result = $member->read();
//rowcount
$num = $result->rowCount();

//check if more than zero members found
if ($num>0) {
//member array
$member_arr = array();
$member_arr["data"] = array();

while ($row = $result->fetch(PDO::FETCH_ASSOC)){
    extract($row);

    $member_record = array(
        "id" => $id,
        "firstName" => $firstName,
        "lastName" => $lastName,
        "email" => $email,
        "addressLine" => $addressLine,
        "city" => $city);

        //push to data
     array_push($member_arr["data"], $member_record);
}

//set response code - 200 OK
http_response_code(200);
//Turn to JSON and output (show members data in JSON format)
echo json_encode($member_arr);

}else{
//set response code - 404 Not found
http_response_code(404);
//tell the user no Members found
echo json_encode(array("message"=>"No Members Found")
);

}
