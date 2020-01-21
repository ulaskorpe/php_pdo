<?php


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 

$mail = new PHPMailer();

var_dump($mail);
die();
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
$mail->AddAddress('ulaskorpe@gmail.com', 'ulas korpe');
$mail->AddCC('ulas.korpe@mobiwan.mobi', 'ulaş körpe');




$mail->CharSet = 'UTF-8';
$mail->Subject = 'mail';

$body = file_get_contents('mail-template.html');

$gelen = ["username"];
$giden = ["ulaş körpe"];

$body = str_replace($gelen,$giden,$body);

$mail->isHTML(true);
$mail->Subject = "Mail Template Ornegi";
$mail->Body = $body;

  
//$mail->MsgHTML($message);
if($mail->Send()) {
 //   echo 'Mail gönderildi!';
	return true;
} else {
    //echo 'Mail gönderilirken bir hata oluştu: ' . $mail->ErrorInfo;
    return false;
}

}else{
	return false;
}

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