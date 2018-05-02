<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

$email = $data->email;

$rows = array();
 $result = $conn->prepare("SELECT * FROM chat WHERE  clientId =?"); 
if($result->execute(array($email))){
	while($row=$result->fetch(PDO::FETCH_OBJ)) {
		$rows["data"][]= $row;
	}
}
 

echo json_encode($rows);


?>
