<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

$keeperID       = $data->keeperID; 	
$id       = $data->id; 		

$result = $conn->prepare("UPDATE keeper SET status = ? WHERE id = ?"); 
if($result->execute(array('confirmed',$keeperID))){
	echo 1;
}	
$result = $conn->prepare("UPDATE notification SET status = ? WHERE id = ?"); 
if($result->execute(array('old',$id))){
	echo 1;
}
// mark dream as active 


?>


