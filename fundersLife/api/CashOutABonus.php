<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

if (isset($data->userID) ){  
$amountInvested        =$data->amount;
$status               ="bonus";
 $package= 1;
$dream= "Cash Out A bonus";
$isAkeeper = "Yes";
$userID = $data->userID;

$result = $conn->prepare("INSERT INTO investment (dateInvested,expecedDate, amountInvested, status,package,dream,isAkeeper,userID)
                VALUES (NOW(),NOW() + INTERVAL $package*30 DAY ,?, ?, ?,?,?,?)"); 


if($result->execute(array($amountInvested, $status, $package,$dream,$isAkeeper,$userID))){
    $investmentID = $conn->lastInsertId();


    $result = $conn->prepare("INSERT INTO withdraw (amount ,  createdate ,  status ,  investmentID  ,  balance ,  notes )
                VALUES (?,NOW(),?,?,?,?)"); 
                if($result->execute(array($amountInvested, 'pending',$investmentID,$amountInvested,$dream))){
                        echo 1;
                }
}		
$result = $conn->prepare("UPDATE  bonus  SET	 
status =?, modifydate = NOW()
WHERE userID= ?"); 
if($result->execute(array('cashedout',$userID))){
echo 1;
}			
}

 
?>
