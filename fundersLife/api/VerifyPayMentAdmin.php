<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data           = json_decode(file_get_contents("php://input"));
$id             = $data->id;
$amount         = $data->amount;
$fromEmail      = $data->email;
$status         = "Active";
$nameFrom       = "";
$comment = $data->comment;

$amountkeepable = "";
if ($amount >= 1000) {
    $amountkeepable = ($amount * 0.5) . "";
}
// 1. verify payment!

$result = $conn->prepare("UPDATE  investment  SET status =?, amountkeepable = ?,comment=? WHERE id= ? ");
$result->execute(array(
    'active',
    $amountkeepable,
    $comment,
    $id    
));
$email = GetEmail($conn, $fromEmail);
// 2. Give a bonus!

$result = $conn->prepare("SELECT * FROM investment WHERE email = ? ");
$result->execute(array(
    $email
));
 

if ($result->rowCount() == 1) {
    // give a 10% bonus
    GiveBonus($conn, $email, $amount * 0.1, $fromEmail, $status,$comment);
} else {
    // give a 2% bonus
    GiveBonus($conn, $email, $amount * 0.02, $fromEmail, $status,$comment);
}
function GiveBonus($conn, $email, $amount, $fromEmail, $status,$comment)
{
    $nameFrom = GetNameFrom($conn, $fromEmail);
    $result   = $conn->prepare("INSERT INTO bonus (email, amount, fromEmail, status,nameFrom)
                VALUES (?,?,?,?,?) ");
    if ($result->execute(array(
        $email,
        $amount,
        $fromEmail,
        $status,
        $nameFrom
    ))) {
        echo $comment;
    }
    
}
function GetEmail($conn, $fromEmail)
{
    $parentlink            = "none";
    $useremailToGiveABonus = "none";
    //1. select parent link from users where email = fromEmail
    $result                = $conn->prepare("SELECT * FROM user WHERE email= ?");
    $result->execute(array(
        $fromEmail
    ));
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $parentlink = $row->parentlink;
        }
    }
    //2. select email  from users where my link = parent link
    
    $result = $conn->prepare("SELECT * FROM user WHERE mylink= ?");
    $result->execute(array(
        $parentlink
    ));
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $useremailToGiveABonus = $row->email;
        }
    }
    return $useremailToGiveABonus;
}
function GetNameFrom($conn, $fromEmail)
{
    $nameFrom = "";
    //1. select parent link from users where email = fromEmail
    
    $result = $conn->prepare("SELECT * FROM user WHERE email= ?");
    $result->execute(array(
        $fromEmail
    ));
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $nameFrom = $row->name;
        }
    }
    //2. select email  from users where my link = parent link
    
    return $nameFrom;
}

?>
?>