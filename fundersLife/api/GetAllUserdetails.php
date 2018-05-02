<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
require "Models/Investements.php";
require "Models/Keeper.php";
$userID = $_GET['userID'];

$rows   = array();
$user = new User();
$user->GetUserData($conn, $userID);
$user->GetDreams($conn);
echo json_encode($user);
class Person
{
    public $id;
    public $name;
    public $surname;
    public $email;
    public $cell;
    public $bankname;
    public $accountType;
    public $branch;
}

 class User{
	public $id;
    public $name;
    public $surname;
	public $email;
	public $password;
    public $cell;
    public $bankname;
    public $accountType;
    public $branch;
    public $referals;
    public $bonusAmount;
    public $accountnumber;

    //Lists 
    public $dreams;

    function GetUserData($conn, $userID){
          $userID;
        $result = $conn->prepare("SELECT * FROM user WHERE id = ?");
        $result->execute(array(
          $userID
        ));
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                $this->id = $row->id;
               $this->name = $row->name;
               $this->surname = $row->surname;
               $this->email = $row->email;
               $this->cell = $row->cell;
               $this->bankname = $row->bankname;
               $this->branch = $row->branch;
               $this->accountType = $row->branch;
               $this->accountnumber = $row->accountnumber;
            }
        }
    }

    function GetDreams($conn){
        $result = $conn->prepare("SELECT * FROM investment WHERE userID = ? and status in (?,?,?,?) ");
        $result->execute(array(
           $this->id, 'paid', 'active', 'allocated','Awaiting allocation'
        ));
        $investements  = array();
if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_OBJ)) {
        $investement                 = new Investement();
        $investement->id             = $row->id;
        $investement->amountInvested = $row->amountInvested;
        $investement->dateInvested   = $row->dateInvested;
        $investement->status         = $row->status;
		$investement->dream          = $row->dream;
		$investement->expecedDate          = $row->expecedDate;
		$investement->package          = $row->package;
        $investement->css            = "dash-box dash-box-color-3";
		$investement->GetKeepers($conn);
		$investement->userID          = $row->userID;
		$investement->timeAllocated = $row->timeAllocated;
		$investement->GetInvestorDetails($conn);
		$investement->GetExpectedAmount($investement->package,$investement->amountInvested);
        $investement->GetDailyGrowth();
        $investements["data"][] = $investement;
    }
} 
$this->dreams =$investements;
    }

}
?>
