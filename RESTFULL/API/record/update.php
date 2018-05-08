<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/record.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 

$record = new Record($db);
 

$data = json_decode(file_get_contents("php://input"));
 

$record->id = $data->id;
 
// set record property values
$record->host = $data->host;
$record->code = $data->code;
$record->message = $data->message;
$record->created = $data->created;
 
// update the record
if($record->update()){
    echo '{';
        echo '"message": "Product was updated."';
    echo '}';
}
 
// if unable to update the record, tell the user
else{
    echo '{';
        echo '"message": "Unable to update record."';
    echo '}';
}

?>