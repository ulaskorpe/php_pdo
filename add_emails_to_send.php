<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');
include "connect.php";
 $date=date("Y-m-d H:i");  


$app_times = $dbh->query("SELECT A.*,B.b2b_id FROM app_event_appointment_times AS A LEFT JOIN app_event_appointments AS B ON A.appointment_id=B.id WHERE user_id>0 and status=0 ORDER BY id LIMIT 0,2000");
$i=1;
foreach ($app_times as $time) {
	echo $i."<br>";
	$email = $dbh->query("SELECT id FROM emails_to_send2 WHERE app_time_id='".$time['id']."'")->fetch(PDO::FETCH_ASSOC);
	if(empty($email['id'])){
			$user = $dbh->query("SELECT * FROM users WHERE id='".$time['user_id']."'")->fetch(PDO::FETCH_ASSOC);
			$file = "approve_mail_".$user['lang'].".html";
			$tx=explode(":",$time['slot_time']);

			$b2b=$dbh->query("SELECT * FROM users WHERE id='".$time['b2b_id']."'")->fetch(PDO::FETCH_ASSOC);

			$co =$dbh->query("SELECT name,stand_id FROM app_event_companies WHERE id='".$b2b['company_id']."'")->fetch(PDO::FETCH_ASSOC);
$content= file_get_contents($file);
$content= str_replace('$lang',$user['lang'],  $content);
$content= str_replace('\'','',  $content);
$content= str_replace('$time',$tx[0].":".$tx[1],  $content);
$content= str_replace('$co_name', $co['name'],  $content);
$content= str_replace('$stand_id', $co['stand_id'],  $content);
$name=$user['name']." ".$user['surname'];
$subject = ($user['lang']=='tr')?"MUSIADEXPO Görüşme Onayı":"MUSIADEXPO Appointment Approval";
		/*	echo $b2b['name'].":".$b2b['company_id'].":".$co['name']."<br>";
			echo $name.":".$user['email'].":".$user['lang']."<br>";
			echo $content;
			echo $file."<hr>";*/
			$sql2="INSERT INTO emails_to_send2 (to_email,to_name,subject,content,is_sent,created_at,sent_at,app_time_id) VALUES ('".$name."','".$user['email']."','".$subject."','".$content."','0','".$date."','0000-00-00 00:00','".$time['id']."')";
			if(! $dbh->query($sql2)){
					echo "<hr>".$sql2;

			};
			$i++;
	}else{
	//	echo "VAR"."<hr>";
	}
	

}



 die();

 /*
$emails_to_send = $dbh->query("SELECT * FROM emails_to_send WHERE app_time_id=0");

foreach ($emails_to_send as $item) {
$user = $dbh->query("SELECT * FROM users WHERE email='".$item['to_email']."'")->fetch(PDO::FETCH_ASSOC);
echo $user['name'].":".$user['lang']."<br>";
echo $item['content'];
echo "<hr>";


}


die();
 $sql = "SELECT A.slot_time,A.id AS time_id,B.slot_date,
C.name,C.surname,C.email,C.company_id,
D.name as to_name,D.email as to_email,D.surname as to_surname ,D.lang,
E.name as co_name
FROM app_event_appointment_times AS A 
LEFT JOIN app_event_appointments AS B ON A.appointment_id = B.id
 LEFT JOIN users AS C ON B.b2b_id=C.id 
 LEFT JOIN users AS D on A.user_id=D.id 
 LEFT JOIN app_event_companies AS E ON C.company_id = E.id WHERE A.user_id>0  AND A.is_sent=0 ORDER BY A.id LIMIT 0,10";

$data = $dbh->query($sql);
 
?>

<table width="100%" border="1">
	
<?php
foreach ($data as $item) {
$mail = $dbh->query("SELECT * FROM emails_to_send WHERE app_time_id='".$item['time_id']."'")->fetch(PDO::FETCH_ASSOC);
if(!empty($mail['id']) ){

	?>


<tr><td><?=$item['lang']?></td><td><?=$item['to_email']?>  -  <?=$mail['to_email']?></td></tr>
<tr><td colspan="2">
	<?=$mail['content']?>

</td></tr>
<?php }else{?>

<tr><td><?=$item['time_id']?> - <?=$item['to_email']?> YOK!!!</td></tr>

	<?php } }?>


</table>
*/