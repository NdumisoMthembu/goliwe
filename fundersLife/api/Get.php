<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

$table = $data->table;
$condition=$data->condition;
$rows = array();
 $sql = "SELECT * FROM $table WHERE $condition";
 
 $result = $conn->prepare("SELECT * FROM $table WHERE $condition"); 
$result->execute(array());

if ($result->rowCount() > 0) {
while($row=$result->fetch(PDO::FETCH_OBJ)) {
		$rows["data"][]= $row;
	}
}

echo json_encode($rows);
//$conn->close();

?>
