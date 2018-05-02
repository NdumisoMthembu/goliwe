<?php
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
						   $this->user = $user;   
					   }
				   }
			   }
		   }
	   }
   }
	}
}
?>