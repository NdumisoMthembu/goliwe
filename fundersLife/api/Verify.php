<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));
   
     $id = $data->id;
	  $status = $data->status;
	  $email = $data->email;
	

        $sql = "UPDATE investment SET
                        status='$status'
                        WHERE id = $id ";        
        
        if ($conn->query($sql) === TRUE) {
          $sql = "SELECT * FROM user WHERE email='$email'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		echo $row['mylink'];
	}
}

        }
        else {
            //echo json_encode('failed');
            echo "Error: " . $sql . "<br>" . $conn->error;
        }    
?>
