<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

if (isset($data->email)) {
    $amount         = $data->amount;
    $investemntId   = $data->investemntId;
    $dream          = $data->dream;
    $email          = $data->email;
    $name           = $data->name;
    $isBonus        = $data->isBonus;
    $status         = "pending";
    $pendingbalance = "--";
    
    
    $result = $conn->prepare("INSERT INTO withdraw (amount  ,  createdate ,  email  ,  status ,  investemntId, name,balance,pendingbalance,dream )
                VALUES (?, NOW(), ?,?,?,?,?,?,?)");
    $result->execute(array(
        $amount,
        $email,
        $status,
        $investemntId,
        $name,
        $amount,
        $pendingbalance,
        $dream
    ));
    // update investment
    $sql = "
                UPDATE  investment  SET      amountkeepable ='' WHERE email=?";
    
    $result = $conn->prepare("UPDATE  investment  SET amountkeepable = ? WHERE email= ?");
    $result->execute(array(
        '',
        $email
    ));
    
} else {
    
    echo json_encode("500");
}
?>
 