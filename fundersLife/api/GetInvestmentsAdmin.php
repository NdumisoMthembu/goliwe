<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

$email = $data->email;
$rows = array();
 $sql = "SELECT * FROM investment";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// cal
		$amount = $row["amountInvested"];
		$due_date = new DateTime($row["dateInvested"]);
		$today = new DateTime();
		$months = $due_date->diff($today);
		$diff = $months->m;
		if($diff >0){
			
			for( $i =1; $i<= $diff; $i++){
				$amount= $amount*1.35;
			}
		}
		
		//endcal
		//create on
		//$investment = new Investment($row["id"] , $row["dateInvested"], $row["amountInvested"], $row["status"], $row["doc"], $row["email"], $amount);
		$investment = new Investment();
		$investment->id = $row["id"];
		$investment->dateInvested = $row["dateInvested"];
		$investment->amountInvested = $row["amountInvested"];
		$investment->status = $row["status"];
		$investment->doc =  $row["doc"];
		$investment->email = $row["email"];
		$investment->amount = ceil($amount);
		//end create ob
		$rows["data"][]= $investment;
	}
}

echo json_encode($rows);
$conn->close();

?>
  <?php
        class Investment {
            public $id ;
            public $dateInvested;
            public $amountInvested;
            public $status;
			public $doc;
            public $email;
            public $amount;
			
         // public function __construct( $id ,  $dateInvested ,  $amountInvested ,  $status ,  $doc ,  $email,$amount) {
		//	$this->$id= $id ;
         //   $this->$dateInvested= $dateInvested;
         //   $this->$amountInvested= $amountInvested;
         //   $this->$status= $status;
         //   $this->$email= $email;
         //   $this->$amount= $amount;
         //   }
			
          }
          
        ?>
