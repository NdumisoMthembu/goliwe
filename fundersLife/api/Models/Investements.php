<?php

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
	public $package;
	public $expectedAmount;
	public $expecedDate;
	public $name;
	public $email;
	public $userID ;
	public $growth;
	public $timeAllocated;
	function GetDailyGrowth(){
		$date1=date_create($this->dateInvested);
		$date2=date_create(date("Y/m/d"));
		$diff=date_diff($date1,$date2);
		$days =  $diff->format("%a");
		$growthToday = $this->amountInvested;
		for($i=-1; $i<$days; $i++ ){
			$growthToday  = $growthToday+$growthToday*0.03;
		}
		$this->growth = round($growthToday);
	}
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
				$keepersLS['data'][] = $keeper;
            }
		}
		
		$this->keepers =  $keepersLS;
	}
	
	function GetExpectedAmount($package, $amountInvested){
		$amount =$amountInvested;
		for($i=0; $i< $package; $i++){
			$amount =$amount+ $amount*0.8;
		}
		$this->expectedAmount = $amount;
	}
}


?>