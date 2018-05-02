<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));
            
			  $code     = $data->code;              
			  $email     = $data->email;              
                 
$result = $conn->prepare("UPDATE  user  SET	 code =? WHERE email= ?"); 
if($result->execute(array($code,$email))){
					echo 1;
} 				
						
?>


