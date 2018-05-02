<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data   = json_decode(file_get_contents("php://input"));
$rows   = array();
$result = $conn->prepare("SELECT * FROM investment");
$result->execute(array(
));
if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_OBJ)) {
        $investement     = new Investement();
		$investement->id = $row->id;
		$investement->status = $row->status;  
        $investement->GetWithdrawals($conn,$row->userID);
        $rows['data'][] = $investement;
    }
    echo json_encode($rows);
}

class Investement
{
	public $id;
	public $hasWithdrawals;
	public $withdrawals; // main focus
	public $status;
    
    function GetWithdrawals($conn,$userID)
    {
        $withdrawals = array();
        $result      = $conn->prepare("SELECT * FROM withdraw WHERE investmentID = ? ORDER BY id ");
        $result->execute(array(
            $this->id
		));
		$this->hasWithdrawals = $result->rowCount();
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                $withdrawal     = new Withdraw();
				$withdrawal->id = $row->id;
				$withdrawal->amount = $row->amount;
				$withdrawal->notes = $row->notes;
				$withdrawal->status = $row->status;
				$withdrawal->GetUser($conn,$userID);
                $withdrawal->GetProvider($conn);
                $withdrawals['withdrawal'][] = $withdrawal;
                
            }
            $this->withdrawals = $withdrawals;
        
        }
    }
    
}

class Withdraw
{
    public $id;
    public $amount;
	public $providers;
	public $notes;
	public $status;
	public $user;
    
	function GetUser($conn,$userID){
	 $providers = array();
        $result    = $conn->prepare("SELECT * FROM user WHERE id = ?");
        $result->execute(array(
           $userID
        ));
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_OBJ)) {
        
				$this->user = $row->name.' '.$row->surname.' - '.$row->email; 
                
            }
            $this->providers = $providers;
          
        }
	}
    function GetProvider($conn)
    {
        $providers = array();
        $result    = $conn->prepare("SELECT * FROM keeper WHERE witdrawalID = ? ORDER BY id ");
        $result->execute(array(
            $this->id
        ));
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                $provider               = new Provider();
				$provider->id           = $row->id;
				$provider->amount           = $row->amount;
				$provider->status           = $row->status;
                $provider->investmentID = $row->investmentID;
                $provider->GetUserDetails($conn);
                $providers['provider'][] = $provider;
                
            }
            $this->providers = $providers;
          
        }
    }
}

class Provider
{
    public $id;
    public $amount;
    public $investmentID;
	public $user;
	public $status;
    function GetUserDetails($conn)
    {
        $result = $conn->prepare("SELECT userID FROM investment WHERE id = ?");
        $result->execute(array(
            $this->investmentID
        ));
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                $userID = $row->userID;
                $result = $conn->prepare("SELECT * FROM user WHERE id = ?");
                $result->execute(array(
                    $userID
                ));
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_OBJ)) {
					   $user = new User();
					   $user->id = $row->id;
					   $user->name = $row->name;
					   $user->surname = $row->surname;
					   $user->email = $row->email;
					   $user->cell = $row->cell;
					   $this->user = $user;
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
    
}
?>