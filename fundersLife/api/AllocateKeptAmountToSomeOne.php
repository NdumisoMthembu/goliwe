<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

if (isset($data->userID)) {
    $amountInvested = $data->amount;
    $status         = "Awaiting allocation";
    $package        = 1;
    $dream          = "Keep Funds Allocated to another dreamer";
    $isAkeeper      = "Yes";
    $userID         = $data->userID;
    $keptamountID   = $data->keptamountID;
    $keep_status    = $data->keep_status;
    $balance        = $data->balance;
    
    $result = $conn->prepare("UPDATE  keptamounts  SET status =?, amount = ? WHERE id= ?");
    if ($result->execute(array(
        $keep_status,
        $balance,
        $keptamountID
    ))) {
        
        $result = $conn->prepare("INSERT INTO investment (dateInvested,expecedDate, amountInvested, status,package,dream,isAkeeper,userID)
        VALUES (NOW(),NOW() + INTERVAL $package*30 DAY ,?, ?, ?,?,?,?)");
        
        
        if ($result->execute(array(
            $amountInvested,
            $status,
            $package,
            $dream,
            $isAkeeper,
            $userID
        ))) {
            echo $investmentID = $conn->lastInsertId();
            
            
        }
    }
    
}


?>