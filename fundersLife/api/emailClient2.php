<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');

if(isset($_POST['emailFrom'])){
$msg = $_POST['msg'];
$emailFrom = $_POST['emailFrom'];
$name = $_POST['name'];
//emailFrom,to,name,subject,msg
 $to = $_POST['to'].",mrnnmthembu@gmail.com";
//$to = "mrnnmthembu@gmail.com";
$subject = $_POST['subject'];

 $message = "
<p>
Hello ".$name.", <br><br>"

.$msg."<br><br>

Regards<br>
<h3>Funders<font color='green'>Life</font></h3>

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