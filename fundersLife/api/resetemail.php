<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

$data = json_decode(file_get_contents("php://input"));
if(isset($data->emailFrom)){
$msg = $data->msg;
$emailFrom = $data->emailFrom;
$name = $data->name;
$code = $data->code;
$link = "http://funderslife.com/reset?code='$code'&email='$emailTo'";
$to = $data->emailTo.",mrnnmthembu@gmail.com";
//$to = "mrnnmthembu@gmail.com";
$subject = "Funders Life";

echo $message = "
<p>

Hey there. 

So, you forgot your password? Well, it happens to the best of us. <br><br>

To change your password, click the link below: <br><br>

<a href='".$link."'>Reset Password <br><br>

Team Funders<font color='green'>Life</font>


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