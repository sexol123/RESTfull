<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/record.php';

$database = new Database();
$db = $database->getConnection();

$record = new record($db);

$stmt = $record->read();
$num = $stmt->rowCount();

if($num>0){
    $records_arr=array();
    $records_arr["records"]=array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $record_item = array(
            "id"=>$id,
            "host"=>$host,
            "code"=>$code,
            "message"=>$message,
            "created"=>$created
        );
        array_push($records_arr["records"], $record_item);
    }
    echo json_encode($records_arr);
}
else{
    echo json_encode(
        array("message"=>"Empty.")
    );
}
?>