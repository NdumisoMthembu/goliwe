<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

require "conn.php";
$id = $_GET['id'];
$rows  = array();

$result = $conn->prepare("SELECT * FROM investment WHERE id = ? ORDER BY id ");
$result->execute(array(
    $id
));
if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_OBJ)) {
        $investement                 = new Investement();
        $investement->id             = $row->id;
        $investement->amountInvested = $row->amountInvested;
        $investement->dateInvested   = $row->dateInvested;
        $investement->status         = $row->status;
		$investement->dream          = $row->dream;
		$investement->expecedDate          = $row->expecedDate;
		$investement->timeAllocated = $row->timeAllocated;
        $investement->css            = "dash-box dash-box-color-3";
		$investement->GetKeepers($conn);
		$investement->userID          = $row->userID;
		$investement->GetInvestorDetails($conn);
        $rows['data'][] = $investement;
    }
}
echo json_encode($rows);
class Investement
{
    public $id;
    public $amountInvested;
    public $dateInvested;
    public $numberOfKeepers;
    public $keepers;
    public $css;
    public $status;
	public $dream;
	public $amountKept;
	public $expecedDate;
	public $name;
	public $email;
	public $userID ;
	public $investement;
	function GetInvestorDetails($conn){
		$result    = $conn->prepare("SELECT * FROM user WHERE id = ?");
        $result->execute(array(
            $this->userID
		));
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_OBJ)) {
				$this->name = $row->name. ' '.$row->surname;
				$this->email =  $row->email;
			}
		}
	}
    function GetKeepers($conn)
    {
        $keepersLS = array();
        $result    = $conn->prepare("SELECT * FROM keeper WHERE investmentID = ?");
        $result->execute(array(
            $this->id
		));
		$this->numberOfKeepers = $result->rowCount();
		$amountKept = 0;
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_OBJ)) {
				$keeper                 = new Keeper();
				$keeper->id             = $row->id;
				$keeper->amount         = $row->amount;
				$keeper->status         = $row->status;
				$keeper->investmentID = $row->investmentID;
				$keeper->witdrawalID = $row->witdrawalID;
				$amountKept = $amountKept+(float) $row->amount;
 				
			 $keeper->GetKepperDetails($conn);
			 $keeper-> GetProofOgPaymentForAKeeper($conn);
				$keepersLS['keepers'][] = $keeper;
            }
		}
		$this->amountKept = $amountKept;
		$this->keepers =  $keepersLS;
    }
}
class Keeper
{
    public $id;
    public $amount;
	public $status;
	public $investmentID;
	public $witdrawalID;
	public $user;
	public $proofOfPayment;

	function GetProofOgPaymentForAKeeper($conn){
  // get doc
  $result = $conn->prepare("SELECT * FROM document WHERE keeperID = ?");
  $result->execute(array(
	 $this->id
  ));
  if ($result->rowCount() > 0) {
	  while ($row = $result->fetch(PDO::FETCH_OBJ)) {
		  $this->proofOfPayment = $row->doc;
	}

	

}
	}
	
	function GetKepperDetails($conn){
   // get users
   $result = $conn->prepare("SELECT * FROM withdraw WHERE id = ?");
   $result->execute(array(
	  $this->witdrawalID
   ));
   if ($result->rowCount() > 0) {
	   while ($row = $result->fetch(PDO::FETCH_OBJ)) {
		   $investemntId = $row->investmentID;
		   // get the original investement
		   $result           = $conn->prepare("SELECT * FROM investment WHERE id = ?");
		   $result->execute(array(
			   $investemntId
		   ));
		   if ($result->rowCount() > 0) {
			   while ($row = $result->fetch(PDO::FETCH_OBJ)) {
				   $userID = $row->userID;
				   // get the user
				   $result     = $conn->prepare("SELECT * FROM user WHERE id = ?");
				   $result->execute(array(
					   $userID
				   ));
				   if ($result->rowCount() > 0) {
					   while ($row = $result->fetch(PDO::FETCH_OBJ)) {
						   //get the user here
						   $user = new User();
						   $user->id = $row->id;
						   $user->name = $row->name;
						   $user->surname = $row->surname;
						   $user->email = $row->email;
						   $user->cell = $row->cell;
						   $user->bankname = $row->bankname;
						   $user->accountType = $row->accountType;
						   $user->branch = $row->branch;
						   $user->accountnumber = $row->accountnumber;
						   $this->user = $user;   
					   }
				   }
			   }
		   }
	   }
   }
	}
}
class User
{
    public $id;
    public $name;
    public $surname;
    public $email;
    public $cell;
    public $bankname;
    public $accountType;
	public $branch;
	public $accountnumber;
}
?>
