<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');
include "connect.php";


$apps=$dbh->query("SELECT A.*,B.b2b_id FROM `app_event_appointment_times` AS A LEFT JOIN app_event_appointments AS B ON A.appointment_id=B.id  where A.user_id>0 ORDER BY A.id DESC");
$i=0;
$j=0;
$ids="";
foreach ($apps as $app) {
$email = $dbh->query("SELECT id FROM emails_to_send2 WHERE app_time_id='".$app['id']."'")->fetch(PDO::FETCH_ASSOC);
if(empty($email['id'])){
	//echo "SELECT id FROM emails_to_send2 WHERE app_time_id='".$app['id']."'"."<br>";




	$i++;
}else{
	///$dbh->query("UPDATE app_event_appointment_times SET is_sent=1,status=1 WHERE id='".$app['id']."'");
	$j++;
//	$ids.=$app['id'].",";
	//echo $app['slot_time']."<br>";
}


}
echo "<hr>".$j.":".$ids;
echo "<hr>".$i;

?>