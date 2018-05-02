<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

              $keeperID       = $data->keeperID; 
			  $doc       = $data->doc; 
			  $toName       = $data->toName; 
			
			  $senderName       = $data->senderName; 
			  $toEmail       = $data->toEmail; 
			  $amount       = $data->amount; 
			 
$result = $conn->prepare("INSERT INTO  document (doc, keeperID, createdate) VALUES (?,?,NOW())"); 
if($result->execute(array($doc,$keeperID))){
	//echo 1;
}	


$result = $conn->prepare("UPDATE  keeper  SET status =? WHERE id= ?"); 
if($result->execute(array('paid',$keeperID))){
	echo 1;
}	

$result = $conn->prepare("INSERT INTO  notification (amount,senderName,toEmail,doc, keeperID,toName,status, createdate) VALUES (?,?,?,?,?,?,?,NOW())"); 
if($result->execute(array($amount,$senderName,$toEmail,$doc,$keeperID,$toName,'new'))){
	//echo 1;
}	
				
?>


