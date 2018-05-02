<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

$email = $data->email;
$pass  = $data->password;
$rows = array();
//PDO PDO PDO  PDO PDO  PDO PDO  PDO PDO  PDO PDO  PDO PDO  PDO PDO  PDO PDO 
$query = $conn->prepare("SELECT * FROM user WHERE email=? AND password =?"); 
$query->execute(array($email, $pass));

while($row=$query->fetch(PDO::FETCH_OBJ)) {
    $rows["user"][] = $row;
}

// PDO PDO  PDO PDO  PDO PDO  PDO PDO  PDO PDO  PDO PDO  PDO PDO  PDO PDO 

echo json_encode($rows);


?>