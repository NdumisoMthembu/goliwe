<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

              $pendingbalance     = $data->pendingbalance; 
			  $id  = $data->id;            
			  $orderId  = $data->orderId;            
			  $email  = $data->email;            
			 
           
		  
				
				$result = $conn->prepare("UPDATE  withdraw  SET	 pendingbalance =? WHERE id= ?"); 
				$result->execute(array($pendingbalance,$id));

// update order with keeper's details	

		
		$result = $conn->prepare("SELECT * FROM user WHERE email= ?"); 
		$result->execute(array($email));
		
		if ($result->rowCount() > 0) {
			while($row=$result->fetch(PDO::FETCH_OBJ)) {
				 $keepername = $row->name;
				 $keeperemail = $row->email;
				 $keepercell = $row->cell;
				 $keeperacc = $row->accountnumber;
				 $keeperbrancode = $row->branch;
				 $keeperbankname = $row->bankname;
		 
		 // update invetement
		  $sql = "
				UPDATE  investment  SET	 
                 keepername ='$keepername',
                 keeperemail ='$keeperemail',
                 keepercell ='$keepercell',
                 keeperacc ='$keeperacc',
                 keeperbrancode ='$keeperbrancode',
                 keeperbankname ='$keeperbankname',
                 status ='allocated',
                 timeallocated =NOW() + INTERVAL 3 DAY
				
				WHERE id= $orderId 		
				";								
				$result = $conn->prepare("UPDATE  investment  SET	 
                 keepername =?,
                 keeperemail =?,
                 keepercell =?,
                 keeperacc =?,
                 keeperbrancode =?,
                 keeperbankname =?,
                 status =?,
                 timeallocated =NOW() + INTERVAL 3 DAY
				
				WHERE id= ? 	"); 
			if($result->execute(array($keepername,$keeperemail,$keepercell,$keeperacc,$keeperbrancode,$keeperbankname,'allocated',$orderId))){
				echo "
					<br><br>
					------------------------------------------------------------------<br> <br> 
					Account Holder Name: $keepername <br> 
					Bank Name: $keeperbankname <br> 
					Branch: $keeperbrancode <br> 
					Account Number: $keeperacc <br>

					------------------------------------------------------------------<br> <br> 
					Cell: $keepercell <br>
					Email: $keeperemail <br>
					------------------------------------------------------------------<br> <br>
					You can call $keepername to confirm their banking details.

					
					";
			}	

			
				
	}
}			
						
?>


