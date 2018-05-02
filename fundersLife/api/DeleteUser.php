<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

$id     = $data->id; 
$result = $conn->prepare("DELETE FROM user 
				WHERE id= ?"); 
if($result->execute(array($id))){
	echo 1;
}	
					
?>


