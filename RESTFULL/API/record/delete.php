<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/record.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare record object
$record = new Record($db);
 
// get record id
$data = json_decode(file_get_contents("php://input"));
 
// set record id to be deleted
$record->id = $data->id;
 
// delete the record
if($record->delete()){
    echo '{';
        echo '"message": "Record was deleted."';
    echo '}';
}
 
// if unable to delete the record
else{
    echo '{';
        echo '"message": "Unable to delete object."';
    echo '}';
}
// delete the record
function delete(){
 
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
 
    // prepare query
    $stmt = $this->connection->prepare($query);
 
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind id of record to delete
    $stmt->bindParam(1, $this->id);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}
?>