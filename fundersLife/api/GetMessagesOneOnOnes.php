<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

$clientId = $data->clientId;

$rows = array();
 $sql = "SELECT * FROM `chat` WHERE  `clientId`='$clientId'";

$result = $conn->prepare("SELECT * FROM chat WHERE  clientId=?"); 
$result->execute(array($clientId));

if ($result->rowCount() > 0) {
  while($row=$result->fetch(PDO::FETCH_OBJ)) {
		$rows["data"][]= $row;
	}
}

// make them read
$result = $conn->prepare("UPDATE  chat  SET	 
				 status = 'read'
				WHERE  clientId=?"); 
$result->execute(array($clientId));

   	
echo json_encode($rows);
//$conn->close();

?>
