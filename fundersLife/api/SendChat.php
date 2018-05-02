<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

if (isset($data->senderEmail) ){  
$senderEmail		= $data->senderEmail;
$senderName		= $data->senderName;
$receiverEmail	=  $data->receiverEmail;
$receiverName	=   $data->receiverName;
$message			=  $data->messageBody;
$clientId			=  $data->clientId;

$result = $conn->prepare("INSERT INTO chat (senderEmail ,  senderName ,  receiverEmail ,  receiverName  ,  timeSent,  message,clientId, status)
                VALUES (?, ?,?,?,NOW(),?,?,?)"); 
if($result->execute(array($senderEmail, $senderName, $receiverEmail, $receiverName,$message,$clientId,'unread'))){
	$result2 = $conn->prepare("UPDATE  chat  SET	status =? WHERE  clientId=?"); 
	echo $result2->execute(array('unread',$clientId));
}
      
        
 
}
 else {

	echo json_encode( "500");
}
?>
