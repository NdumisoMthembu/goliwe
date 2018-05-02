<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

			  $id  = $data->id;            
			
				$result = $conn->prepare("UPDATE  investment  SET status =? , timeAllocated=NOW() + INTERVAL $package*3 DAY WHERE id= ?"); 
				if($result->execute(array('allocated',$id))){
					echo 1;
				}			
?>


