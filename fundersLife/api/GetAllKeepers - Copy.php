<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data   = json_decode(file_get_contents("php://input"));
$rows   = array();
$result = $conn->prepare("SELECT * FROM keeper");
$result->execute(array());
if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_OBJ)) {
        $keeper               = new Keeper();
        $keeper->id           = $row->id;
        $keeper->amount       = $row->amount;
        $keeper->witdrawalID  = $row->witdrawalID;
        $keeper->investmentID = $row->investmentID;
        $keeper->createdate   = $row->createdate;
        
        
        $keeper->GetUser($conn);
        
        $rows['data'][] = $keeper;
    }
}
echo json_encode($rows);
class Keeper
{
    public $id;
    public $amount;
    public $witdrawalID;
    
    public $dateAllocated;
    public $investmentID;
    public $createdate;
    
    public $user;
    
    function GetUser($conn)
    {
        // get users
        
        $result = $conn->prepare("SELECT * FROM investment WHERE id = ?");
        $result->execute(array(
            $this->investmentID
        ));
        if ($result->rowCount() > 0) {
            while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                $userID = $row->userID;
                // get the user
                $result = $conn->prepare("SELECT * FROM user WHERE id = ?");
                $result->execute(array(
                    $userID
                ));
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_OBJ)) {
                        //get the user here
                        $user              = new User();
                        $user->id          = $row->id;
                        $user->name        = $row->name;
                        $user->surname     = $row->surname;
                        $user->email       = $row->email;
                        $user->cell        = $row->cell;
                        $user->bankname    = $row->bankname;
                        $user->accountType = $row->accountType;
                        $user->branch      = $row->branch;
                        $this->user        = $user;
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
}
?>