<?php


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function sendMail($to,$name,$subject,$key,$message,$cc=null,$cc_name=null){

echo $key;

if($key == 'mar13k172al'){

$mail = new PHPMailer();


$mail->isSMTP();
//$mail->SMTPKeepAlive = true;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls'; //ssl

//$mail->Port = 587; //25 , 465 , 587
//$mail->Host = "smtp.gmail.com";
$mail->Host = 'smtp.mailgun.org';
$mail->Port = 25;

$mail->Username = 'postmaster@mg.musiadexpo.com';
$mail->Password = '45750a74bbdd11b0b6cc36906bc5ac47-a5d1a068-888d8596';


$mail->setFrom('duyuru@musiad-bulten.com', 'MusiadEXPO');
///$mail->addAddress("kdrksm@gmail.com");
$mail->AddAddress($to, $name);
if($cc){
	$cc_name = ($cc_name!=null)?$cc_name:'';
	$mail->AddCC($cc, $cc_name);
}




$mail->CharSet = 'UTF-8';
$mail->Subject = $subject;
$mail->MsgHTML($message);
if($mail->Send()) {
    echo 'Mail gönderildi!';
	return true;
} else {
    echo 'Mail gönderilirken bir hata oluştu: ' . $mail->ErrorInfo;
    return false;
}

}else{
	return false;
}

}

//function sendMail($to,$name,$subject,$key,$message,$cc=null,$cc_name=null){
if(sendMail('ulaskorpe@gmail.com','ulaş körpe','naber','mar13k172al','<h1>bu da mesajın</h1>','ulas.korpe@mobiwan.mobi','ulaşşş')){
	echo "yolladım ";
}
/*

$body = file_get_contents('./mail-template.html');

$gelen = ["username","userID"];
$giden = ["Mehmet",8];

$body = str_replace($gelen,$giden,$body);

$mail->isHTML(true);
$mail->Subject = "Mail Template Ornegi";
$mail->Body = $body;

if ($mail->send())
    echo "Mail gonderimi basarili.";
else
    echo "Malesef olmadi.";

*/
 
 




?>