<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

              $cell     = $data->cell; 
			  $address  = $data->address;  
			  $idnum    = $data->idnum;
			  $country  = $data->country;  
			  $city     = $data->city;               
			  $email     = $data->email;               
                 
           								
			$result = $conn->prepare("
			UPDATE  user  SET	 
				 cell = ?, 
				 address =?,
                 idnum =?,
                 country =?,
                 city =?
				WHERE email= ?
			"); 
if($result->execute(array($cell,$address,$idnum,$country,$city,$email))){
	echo 1;
}		
						

?>


