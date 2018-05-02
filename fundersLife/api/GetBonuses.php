<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));
$userID= $data->userID;
$status= $data->status;
$rows = array(); 

class Bonus{
public $id;
public $nameFrom;
public $emailFrom;
public $fromID;
public $amount;
public $createdate;

function GetUserFrom($conn){
	$result = $conn->prepare("SELECT * FROM user WHERE id =?"); 
	$result->execute(array($this->fromID));
	if ($result->rowCount() > 0) {
		while($row=$result->fetch(PDO::FETCH_OBJ)) {
			$this->nameFrom = $row->name. ' '.$row->surname;
			$this->emailFrom = $row->email;
			}
		}
}
}
 $result = $conn->prepare("SELECT * FROM bonus WHERE userID=? and status = ?"); 
$result->execute(array($userID,$status));
if ($result->rowCount() > 0) {
while($row=$result->fetch(PDO::FETCH_OBJ)) {
	$data = new Bonus();
	$data->amount = $row->amount;
	$data->fromID = $row->fromID;
	$data->createdate = $row->createdate;
	$data-> GetUserFrom($conn);
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
?>
