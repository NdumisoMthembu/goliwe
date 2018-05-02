<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
require "Models/Investements.php";
require "Models/Keeper.php";
require "Models/Person.php";
$data = json_decode(file_get_contents("php://input"));
$email = $data->email;
$pass= $data->password;

$rows   = array();
$user = new User();
$user->GetUserData($conn,  $email, $pass);
$user->GetDreams($conn);
$user->GetMyRefferals($conn);
$user->GetBonus($conn);
$user->GetAmountKept($conn);

echo json_encode($user);
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
    public $accountnumber;
    public $role;
    public $mylink;
    public $isAkeeper;
    public $address , $country , $city ,$idnum;
    //side menu
    public $myrefferals;
    public $bonus;
    public $amountkept;
	public $isEmailVerified;
	public $code;
	public $userstatus;


    //Lists 
    public $dreams;
    public $myrefferalsLS;
    public $bonusLS;

    function GetUserData($conn, $email, $pass){
          $userID;
        $result = $conn->prepare("SELECT * FROM user WHERE email = ? AND password = ?");
        $result->execute(array(
          $email, $pass
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
               $this->accountType = $row->accountType;
               $this->accountnumber = $row->accountnumber;
               $this->role = $row->role;
               $this->mylink = $row->mylink;
               $this->isAkeeper =$row->isAkeeper;
               $this->password = $row->password;
               $this->idnum = $row->idnum;
               $this->city = $row->city;
               $this->country = $row->country;
               $this->address = $row->address;  
			   $this->userstatus = $row->userstatus; 
			   $this->isEmailVerified=$row->isEmailVerified; 
			     $this->code=$row->code; 
            }
        }
    }
function GetMyRefferals($conn){
    $result = $conn->prepare("SELECT * FROM user WHERE parentlink = ?");
    $result->execute(array(
       $this->mylink
    ));
    $this->myrefferals = $result->rowCount();
    $myrefferalsLS  = array();
    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_OBJ)) {
            $data                 = new Person();
            $data->id             = $row->id;
            $data->name = $row->name;
            $data->surname   = $row->surname;
            $data->email         = $row->email;
            $data->status         = $row->userstatus;
            $myrefferalsLS["data"][] = $data;
        }
    } 
    $this->myrefferalsLS =$myrefferalsLS;
}

function GetBonus($conn){
$result      =$conn->prepare("SELECT * FROM bonus WHERE userID = ? and status =?"); 
$result->execute(array($this->id, 'active')); 
$amount      = 0;
if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_OBJ)) {
        $amount = $amount + $row->amount;
    }
}
$this->bonus  = $amount;
}

function GetAmountKept($conn){
    $result      =$conn->prepare("SELECT * FROM keptamounts WHERE  userID=? AND status = ?"); 
    $result->execute(array($this->id, 'kept'));
    
    $amountkept = 0;
    if ($result->rowCount() > 0) {
       while ($row = $result->fetch(PDO::FETCH_OBJ)){
          $amountkept = $amountkept +$row->amount;
      }
    }
   
    $this->amountkept  = $amountkept;
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
