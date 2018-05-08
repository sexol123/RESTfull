<?php
header("Access-Controll-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../objects/record.php';
include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();
$record = new Record($db);

$data = json_decode(file_get_contents("php://input"));



if (!empty($record)) {
    $record->host = $data->host;
}
  

if (!empty($record)) {
    $record->code = $data->code;
}
if (!empty($record)) {
    $record->message = $data->message;
}
//$record->created = $data->created;

if($record->create()){
    echo '{';
        echo '"message": "Product was created."';
        
    echo '}';
}
 
else{
    echo '{';
        echo '"message": "Unable to create record."';
       
    echo '}';
}

function create()
{

// query to insert record
    $query = "INSERT INTO
                ".$this->table_name."
            SET
                host=:host, code=:code, message=:message";

// prepare query
    $stmt = $this->connection->prepare($query);

// sanitize
    $this->host = htmlspecialchars(strip_tags($this->host));
    $this->code = htmlspecialchars(strip_tags($this->code));
    $this->message = htmlspecialchars(strip_tags($this->message));
    //$this->created = htmlspecialchars(strip_tags($this->created));

// bind values
    $stmt->bindParam(":host", $this->host);
    $stmt->bindParam(":code", $this->code);
    $stmt->bindParam(":message", $this->message);
    //$stmt->bindParam(":created", $this->created);

// execute query
    // if ($stmt->execute()) {
        
    //     return true;
    // }

    // return false;

    return $stmt->execute();
}
?>
