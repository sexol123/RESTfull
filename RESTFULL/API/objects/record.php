<?php
class Record
{
    private $connection;
    private $table_name = "reports";

    public $id;
    public $host;
    public $code;
    public $message;
    public $created;

    public function __construct($db){
        $this->connection = $db;
    }

    function read(){
        $query = "SELECT * 
                FROM
                ".$this->table_name."";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // create product
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                host=:host, code=:code, message=:message";
 
    // prepare query
    $stmt = $this->connection->prepare($query);
 
    // sanitize
   // $this->id=htmlspecialchars(strip_tags($this->id));
    $this->host=htmlspecialchars(strip_tags($this->host));
    $this->code=htmlspecialchars(strip_tags($this->code));
    $this->message=htmlspecialchars(strip_tags($this->message));
   // $this->created=htmlspecialchars(strip_tags($this->created));
 
    // bind values
   // $stmt->bindParam(":id", $this->id);
    $stmt->bindParam(":host", $this->host);
    $stmt->bindParam(":code", $this->code);
    $stmt->bindParam(":message", $this->message);
    //$stmt->bindParam(":created", $this->created);
 
    // execute query
    if($stmt->execute()){
        return true;
    }
 
    return false;
     
}

// used when filling up the update product form
function readOne(){
 
    // query to read single record
    $query = "SELECT
                id, host, code, message, created
            FROM
                " . $this->table_name . " 
                
            WHERE
                id = ".$this->id."
            LIMIT
                1";
 
    // prepare query statement
    $stmt = $this->connection->prepare( $query );
    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);
 
    // execute query
    $stmt->execute();
 
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // set values to object properties
    $this->host = $row['host'];
    $this->code = $row['code'];
    $this->message = $row['message'];
    $this->created = $row['created'];
    
}

function update(){
 
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                host = :host,
                code = :code,
                message = :message,
                created = :created
            WHERE
                id = :id";
 
    // prepare query statement
    $stmt = $this->connection->prepare($query);
 
    // sanitize
    $this->host=htmlspecialchars(strip_tags($this->host));
    $this->code=htmlspecialchars(strip_tags($this->code));
    $this->message=htmlspecialchars(strip_tags($this->message));
    $this->created=htmlspecialchars(strip_tags($this->created));
    $this->id=htmlspecialchars(strip_tags($this->id));
 
    // bind new values
    $stmt->bindParam(':created', $this->created);
    $stmt->bindParam(':host', $this->host);
    $stmt->bindParam(':code', $this->code);
    $stmt->bindParam(':message', $this->message);
    $stmt->bindParam(':id', $this->id);
 
    // execute the query
    if($stmt->execute()){
        return true;
    }
    return false;
}
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

}
?>
