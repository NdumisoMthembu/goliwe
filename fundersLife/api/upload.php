<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
//require "conn.php";
$data = json_decode(file_get_contents("php://input"));
if (isset($_POST['name']) ){
$name = $_POST['name'];
$target_dir = "uploads/";
echo $target_file = $target_dir .time(). basename($_FILES["file"]["name"]);
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
}

?>

