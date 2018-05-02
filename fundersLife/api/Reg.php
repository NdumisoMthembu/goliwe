<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

if (isset($data->email) ){  
 $name 		=$data->name;
 $surname 	=$data->surname;
 $email 	=$data->email;
 $password 	=$data->password;
 $code 	=$data->code;
 $parentlink 	=$data->parentlink;
 $mylink 	=$data->baseUrl."?link=".time().$code;
 
 // check if user exits
$result = $conn->prepare("SELECT * FROM user WHERE email = ?"); 
$result->execute(array($email));
if ($result->rowCount() ==0) {

$result = $conn->prepare("INSERT INTO user (name, surname, email, password, createdate, role,code,isEmailVerified,mylink,parentlink,isAkeeper)
                VALUES (?,?,?,?, now(),?,?,?,?,?,?)"); 
if($result->execute(array($name, $surname, $email,$password,'Client',$code,0,$mylink,$parentlink,'Yes'))){
	 echo 1;
}else{
	echo "error while trying to register client step 1 of 3";
}		

	
}else{
	
	echo "Your account already exists, please go to login";
}
 
 
 
        
 
}
 else {

	echo json_encode( "500");
}
?>