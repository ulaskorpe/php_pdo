<?php


require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include "connect.php";



$id_list="";
//$emails=$dbh->query("SELECT * FROM emails_to_send2 WHERE is_sent='0' AND content LIKE '%Approved%' ORDER BY RAND() LIMIT 1");
//$emails=$dbh->query("SELECT * FROM emails_to_send2 WHERE is_sent='0' ORDER BY id LIMIT 30");
$emails=$dbh->query("SELECT * FROM emails_to_send2 WHERE is_sent='0' ORDER BY id LIMIT 20");
//$emails=$dbh->query("SELECT * FROM `emails_to_send2` WHERE to_name like '%korpe%'");
foreach($emails as $email){
echo $email['to_email'].":".$email['to_name'].":".$email['subject']."<br>";
//echo $email['content'];

$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPKeepAlive = true;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls'; //ssl
$mail->Host = 'smtp.mailgun.org';
$mail->Port = 587;
$mail->Username = 'postmaster@mg.musiadexpo.com';
$mail->Password = '45750a74bbdd11b0b6cc36906bc5ac47-a5d1a068-888d8596';
$mail->setFrom('duyuru@musiad-bulten.com', 'MusiadEXPO');
$mail->CharSet = 'UTF-8';


$mail->AddAddress($email['to_name'],$email['to_email']);
$mail->Subject = $email['subject'];
$mail->MsgHTML($email['content']);

 if($mail->Send()){
 		$dbh->query("UPDATE emails_to_send2 SET is_sent='1',sent_at='".date('Y-m-d H:i')."' WHERE id='".$email['id']."'");
 		$dbh->query("UPDATE app_event_appointment_times  SET is_sent='1',status='1' WHERE id='".$email['app_time_id']."'");
 		echo $email['to_name']."<br>";
 }else{
 		echo "<font style='color:red'>".$email['id']." GÖNDERİLEMEDİ!!!</font><br>";
 		$id_list.=",".$email['id'];
 }	
echo "<hr>";

}
echo "ok".$id_list;
die();
 //hasan@kartons.com.tr
$mail->AddAddress('ulaskorpe@gmail.com','ulaş körpe');
$mail->Subject = 'konusuz';
$mail->MsgHTML('<b>içerik</b>');

 

try{
$mail->Send();
} catch(Exception $e) {
    echo $e->getMessage();
}

die();
if($mail->Send()) {
echo "sent";
//$dbh->query("UPDATE emails_to_send SET is_sent=1,sent_at='".date('Y-m-d H:i:s')."' WHERE id='".$row['id']."'");
}///sent mail
 

//echo $row['to_email'];



    
 

/*
 *     {% partial "grid-gallery" %}
 * */
?>