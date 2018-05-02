<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

              $isAkeeper       = $data->isAkeeper; 
              $email       = $data->email; 
			 
$result = $conn->prepare("UPDATE  user  SET	 
                 isAkeeper =?
                 WHERE email= ? "); 
if($result->execute(array($isAkeeper,$email))){
	echo 1;
}	
				
						
?>


