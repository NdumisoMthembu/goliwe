<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

              $bankname     = $data->bankname; 
			  $accountnumber  = $data->accountnumber;            
			  $email     = $data->email;              
			  $accountType     = $data->accountType;              
			  $branch     = $data->branch;              
			  $email     = $data->email; 
			  $isAkeeper  = $data->isAkeeper;             
                 
           
$result = $conn->prepare("
UPDATE  user  SET	 
                 bankname =?,
                 accountnumber =?,
                 branch =?,
				 accountType = ?,
				 isAkeeper=?
				WHERE email= ? 
"); 
echo $result->execute(array($bankname,$accountnumber,$branch,$accountType,$isAkeeper,$email));				
						
?>


