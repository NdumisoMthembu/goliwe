<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require "conn.php";
$data = json_decode(file_get_contents("php://input"));

$rows = array();
//pendings
$result = $conn->prepare("SELECT * FROM investment WHERE status = ?"); 
$result->execute(array('Awaiting allocation'));

$counts = new Counts();
$counts->key ="Awaiting allocation";
$counts->value =$result->rowCount() ;
$rows["data"][]= $counts;

//active
$result = $conn->prepare("SELECT * FROM investment WHERE status = ?"); 
$result->execute(array('active'));

$counts = new Counts();
$counts->key ="Active";
$counts->value =$result->rowCount() ;
$rows["data"][]= $counts;

//allocated

$result = $conn->prepare("SELECT * FROM investment WHERE status = ?"); 
$result->execute(array('allocated'));


$counts = new Counts();
$counts->key ="Allocated";
$counts->value =$result->rowCount() ;
$rows["data"][]= $counts;

//paid
$result = $conn->prepare("SELECT * FROM notification WHERE status = ?"); 
$result->execute(array('new'));

$counts = new Counts();
$counts->key ="Paid";
$counts->value =$result->rowCount() ;
$rows["data"][]= $counts;

//users 
 
$result = $conn->prepare("SELECT * FROM user WHERE role <> ?"); 
$result->execute(array('admin'));

$counts = new Counts();
$counts->key ="Users";
$counts->value =$result->rowCount() ;
$rows["data"][]= $counts;


//Messages
$result = $conn->prepare("SELECT * FROM chat WHERE ?"); 
$result->execute(array(1));


$counts = new Counts();
$counts->key ="Messages";
$counts->value =$result->rowCount() ;
$rows["data"][]= $counts;

// Keepers


$result = $conn->prepare("SELECT * from keptamounts"); 
$result->execute(array());


$counts = new Counts();
$counts->key ="Keepers";
$counts->value =$result->rowCount() ;
$rows["data"][]= $counts;

// Widrawls


$result = $conn->prepare("SELECT * FROM withdraw WHERE balance > ?"); 
$result->execute(array(0));


$counts = new Counts();
$counts->key ="Widrawls";
$counts->value =$result->rowCount() ;
$rows["data"][]= $counts;


//$conn->close();
// done .... RETURN OBJECT
echo json_encode($rows);

?>
  <?php
        class Counts {
            public $key ;
            public $value;
			
			//public $users;
            //public $pendings ;
            //public $allocated;
            //public $active;
            //public $paid;
          }
          
        ?>
