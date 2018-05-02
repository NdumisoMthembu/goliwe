
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
$result = $conn->prepare("SELECT * FROM investment WHERE email = ? ORDER BY id desc"); 
$result->execute(array($email));

while($row=$result->fetch(PDO::FETCH_OBJ)) {
    $rows["user"][] = $row;
}
$counts->value  = $result->rowCount();
// PDO PDO  PDO PDO  PDO PDO  PDO PDO  PDO PDO  PDO PDO  PDO PDO  PDO PDO 

echo json_encode($rows);


?>