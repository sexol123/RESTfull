<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/record.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare record object
$record = new Record($db);
 
// set ID property of record to be edited
$record->id = isset($_GET['id']) ? $_GET['id'] : die();

 
// read the details of record to be edited
$record->readOne();


// create array
$record_arr = array(
    "id" =>  $record->id,
    "host" => $record->host,
    "code" => $record->code,
    "message" => $record->message,
    "created"=> $record->created
 
);

print_r(json_encode($record_arr));
?>