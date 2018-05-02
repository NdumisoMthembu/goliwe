<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));
$rows = array();
 $sql = "SELECT * FROM investment WHERE status='pending'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		// cal
		$package=  $row["package"];
		$amountInvested=  $row["amountInvested"];
		$matches = 0;
		$email =  $row["email"];
		
		$sql_count = "SELECT * FROM withdraw WHERE amount='$amountInvested' AND package=$package AND status = 'waiting for provider' AND email <> '$email'";
		$result_count  = $conn->query($sql_count);
		$matches =$result_count->num_rows;
		//endcal
		//create on
		$investment = new Investment();
		$investment->id = $row["id"];
		$investment->dateInvested = $row["dateInvested"];
		$investment->amountInvested = $amountInvested;
		$investment->status = $row["status"];
		$investment->doc =  $row["doc"];
		$investment->email = $email;
		$investment->package = $package;
		$investment->dream = $row["dream"];
		$investment->name = $row["name"];
		$investment->matches = $matches;
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
            public $package;
            public $dream;
            public $matches;
			
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
