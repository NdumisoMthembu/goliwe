<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));
  $code     = $data->code;              
  $email     = $data->email;      

$rows = array();
 
 $result = $conn->prepare("SELECT * FROM user WHERE  email=? AND  code=?"); 
$result->execute(array($email,$code));

 //$sql = "SELECT * FROM chat WHERE senderName ='$email' OR receiverEmail ='$email' ";

if ($result->rowCount() > 0) {
    while($row = $result->fetch_assoc()) {
		$rows["data"][]= $row;
	}
}

echo json_encode($rows);
$conn->close();

?>
