<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

$data = json_decode(file_get_contents("php://input"));
if(isset($data->emailFrom)){
$msg = $data->msg;
$emailFrom = $data->emailFrom;
$name = $data->name;

$to = $data->emailTo.",mrnnmthembu@gmail.com";
//$to = "mrnnmthembu@gmail.com";
$subject = "World Wide Cash";

echo $message = "
<p>
Hello ".$name.", <br><br>"

.$msg."<br><br>

Regards<br>
World Wide Cash Customer Care

</p>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= "From: <".$emailFrom.">" . "\r\n";

if(mail($to,$subject,$message,$headers)){
    echo 1;
}
}else
{
	
	echo 500;
}
?>