<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

if (isset($data->amount) ){  
    $amount = $data->amount;
    $status= 'pending';
    $investmentID= $data->investmentID;
    $witdrawalID= $data->witdrawalID;
    $balance = $data->balance;

    $result = $conn->prepare("INSERT INTO keeper (amount, status, investmentID,createdate,witdrawalID) VALUES (?,?,?,NOW(),?)"); 
if($result->execute(array(
$amount,
$status,
$investmentID,
$witdrawalID
))){
	// update balance 
$result = $conn->prepare("UPDATE   withdraw SET balance = ? where id = ?"); 	
if($result->execute(array(
    $balance,
    $witdrawalID
    ))){
        echo 1;
    }
}else{
    echo 0;
}	
		
}

?>
