<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$parentlink = $_GET['parentlink'];
$email = $_GET['email'];
$userID = $_GET['userID'];


$rows = array();
 
//members

if ($parentlink == "") {
    $parentlink = "none";
}
$query = $conn->prepare("SELECT * FROM user WHERE parentlink = ? AND isEmailVerified=?"); 
$query->execute(array($parentlink, 1));

$counts         = new Counts();
$counts->key    = "members";
$counts->value  = $query->rowCount();
$rows["data"][] = $counts;    

//bonus
$sql         = 
$result      =$conn->prepare("SELECT * FROM bonus WHERE userID = ? and status =?"); 
$result->execute(array($userID, 'active')); 
$counts      = new Counts();
$counts->key = "bonus";
$amount      = 0;
if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_OBJ)) {
        $amount = $amount + $row->amount;
    }
}
$counts->value  = $amount;
$rows["data"][] = $counts;

//Pending with draw
$result      =$conn->prepare("SELECT * FROM withdraw WHERE email = ? and status =?"); 
$result->execute(array($email, 'pending'));
$counts         = new Counts();
$counts->key    = "pending";
$counts->value  = $result->rowCount();
$rows["data"][] = $counts;

//PENING INVESTMENTS
$result      =$conn->prepare("SELECT * FROM investment WHERE  email=? AND status IN (?,?,?)"); 
$result->execute(array($email,'Awaiting allocation','paid', 'allocated'));

$counts         = new Counts();
$counts->key    = "pending_investment";
$counts->value  = $result->rowCount();
$rows["data"][] = $counts;

//ALLOCATED INVESTMENTS
$result      =$conn->prepare("SELECT * FROM investment WHERE  email=? AND status =? "); 
$result->execute(array($email, 'allocated'));

$counts        = new Counts();
$counts->key   = "allocated";
$timeallocated = "";
if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_OBJ)){
        $timeallocated = $row->timeallocated;
    }
    $counts->value = $timeallocated;
}
$rows["data"][] = $counts;
//get amount to keep
$result      =$conn->prepare("SELECT * FROM investment WHERE  email=? AND amountkeepable <> ? "); 
$result->execute(array($email, ''));

$keepableAmount = 0;
if ($result->rowCount() > 0) {
  while ($row = $result->fetch(PDO::FETCH_OBJ)){
      $keepableAmount = $keepableAmount + $row->amountkeepable;
  }
}
$counts         = new Counts();
$counts->key    = "keepableAmount";
$counts->value  = $keepableAmount; 
$rows["data"][] = $counts;

//get amount kept
$result      =$conn->prepare("SELECT * FROM keptamounts WHERE  userID=? AND status = ?"); 
$result->execute(array($userID, 'kept'));

$amountkept = 0;
if ($result->rowCount() > 0) {
   while ($row = $result->fetch(PDO::FETCH_OBJ)){
      $amountkept = $amountkept +$row->amount;
  }
}
$counts         = new Counts();
$counts->key    = "amountkept";
$counts->value  = $amountkept;
$rows["data"][] = $counts;
//end objects

echo json_encode($rows);




//$conn->close();

?>
 <?php
class Counts
{
    public $key;
    public $value;
}

?>
 