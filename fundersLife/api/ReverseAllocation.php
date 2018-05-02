<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

              $witdrawalID       = $data->witdrawalID; 
			  $amount       = $data->amount; 
			  $userID       = $data->userID; 
			 
$result = $conn->prepare("SELECT * FROM withdraw WHERE id = ?"); 
$result->execute(array(
	$witdrawalID
  ));
if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_OBJ)) {
        $withdrawal                 = new Withdrawal();
        $withdrawal->id             = $row->id;
        $withdrawal->amount = $row->amount;
		$withdrawal->Reverse($conn,$amount);
		$withdrawal->ChangeKeeperStatus($conn);
		$withdrawal->LockUser($conn, $userID);
    }
}

class Withdrawal{
	public $id;
	public $amount;

	function Reverse($conn,$amount){
		echo $newamount =  (float) $this->amount +  (float) $amount;
		$result = $conn->prepare("UPDATE  withdraw  SET amount =? WHERE id= ?"); 
		if($result->execute(array($newamount,$this->id))){
			echo 'withdraw.amount-> R', $amount , ' to R', $newamount, ' ------ ';
		}	
	}
	function ChangeKeeperStatus($conn){
		$result = $conn->prepare("UPDATE  keeper  SET status =? WHERE witdrawalID= ?"); 
		if($result->execute(array('reversed',$this->id))){
			echo 'keeper.status->reversed',  ' ------ ';
		}	
	}
	function LockUser($conn, $userID){
		$result = $conn->prepare("UPDATE  user  SET userstatus =? WHERE id= ?"); 
		if($result->execute(array('locked',$userID))){
			echo 'user.userstatus->locked', $userID, ' ----- ';
		}	
	}
}
			
?>


