<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));


$email = $data->email;
$code  = $data->code;

$result = $conn->prepare("UPDATE  user  SET     
                 isEmailVerified =?,
                 code =?
                WHERE email= ?");
if ($result->execute(array(
    1,
    $code,
    $email
))) {
echo 1;
}

?>


 