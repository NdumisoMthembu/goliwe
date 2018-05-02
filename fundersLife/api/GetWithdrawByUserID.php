<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));
$investmentID= $data->investmentId;

$rows = array(); 
 $result = $conn->prepare("SELECT * FROM withdraw WHERE investmentID <> ? AND status = ? AND balance > ?"); 
$result->execute(array($investmentID,'pending',0));
if ($result->rowCount() > 0) {
while($row=$result->fetch(PDO::FETCH_OBJ)) {
	$data = new Withdraw();
	$data->investmentID = $row->investmentID;
	$data->amount = $row->amount;
	$data->balance = $row->balance;
	$data->id = $row->id;
	$data->notes = $row->notes;
	$data-> GetUser($conn);
	$rows['data'][] = $data;
	}
}

echo json_encode($rows);
//$conn->close();
class Withdraw {
public $id;
public $investmentID;
public $name;
public $email;
public $amount;
public $balance;
public $notes;
public $keepers;


function GetKeepers($conn)
{
	$keepersLS = array();
	$result    = $conn->prepare("SELECT * FROM keeper WHERE witdrawalID = ?");
	$result->execute(array(
		$this->id
	));
	$this->numberOfKeepers = $result->rowCount();
	if ($result->rowCount() > 0) {
		while ($row = $result->fetch(PDO::FETCH_OBJ)) {
			$keeper                 = new Keeper();
			$keeper->id             = $row->id;
			$keeper->amount         = $row->amount;
			$keeper->status         = $row->status;
			$keeper->investmentID = $row->investmentID;
			$keeper->witdrawalID = $row->witdrawalID;
		 $keeper->GetKepperDetails($conn);
		 $keeper-> GetProofOgPaymentForAKeeper($conn);
			$keepersLS['keepers'][] = $keeper;
		}
	}
	
	$this->keepers =  $keepersLS;
}
function GetUser($conn){
	$result = $conn->prepare("SELECT * FROM investment WHERE id = ?");
	$result->execute(array(
	   $this->investmentID
	));
	if ($result->rowCount() > 0) {
		while ($row = $result->fetch(PDO::FETCH_OBJ)) {
			$userID = $row->userID;
			//get user
			$result = $conn->prepare("SELECT * FROM user WHERE id = ?");
			$result->execute(array(
				$userID
			));
			if ($result->rowCount() > 0) {
				while ($row = $result->fetch(PDO::FETCH_OBJ)) {
					$this->name = $row->name.' '.$row->surname;
					$this->email= $row->email;
				}
			}
		}
	}
}

}
require 'Keeper.php';
?>
