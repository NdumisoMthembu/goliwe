<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));
               
			  $email     = $data->email;               
        
				$result = $conn->prepare("UPDATE  user  SET	 
				 userstatus =?
				WHERE email= ?"); 
if($result->execute(array('active',$email))){
	echo 1;
}	

?>


