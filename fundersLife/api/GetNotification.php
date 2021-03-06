<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));
$email= $data->email;

$rows = array();


$result = $conn->prepare("SELECT * FROM notification WHERE toEmail = ? AND status=?"); 
$result->execute(array($email,'new'));

if ($result->rowCount() > 0) { 
   while($row=$result->fetch(PDO::FETCH_OBJ)) {
		$rows["data"][]= $row; 
	}
}

echo json_encode($rows);
//$conn->close();

?>
