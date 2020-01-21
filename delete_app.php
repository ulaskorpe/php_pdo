<?php
include "connect.php";

///29151 36170

 

$appointment = $dbh->query("SELECT B.id,slot_time FROM app_event_appointments AS A LEFT JOIN app_event_appointment_times AS B ON A.id=B.appointment_id WHERE A.b2b_id='".$_REQUEST['b2b_id']."' AND B.user_id='".$_REQUEST['user_id']."'")->fetch(PDO::FETCH_ASSOC);


$email_to_send = $dbh->query("SELECT id FROM emails_to_send WHERE app_time_id='".$appointment['id']."'")->fetch(PDO::FETCH_ASSOC);



if(empty($email_to_send['id'])){
	$user = $dbh->query("SELECT name,surname FROM users WHERE id='".$_REQUEST['user_id']."'")->fetch(PDO::FETCH_ASSOC);
	$name = $user['name']." ".$user['surname'];
	$to_user = $dbh->query("SELECT email FROM users WHERE id='".$_REQUEST['b2b_id']."'")->fetch(PDO::FETCH_ASSOC);
	$email_to_send=$dbh->query("SELECT id FROM emails_to_send WHERE to_email='".$to_user['email']."'")->fetch(PDO::FETCH_ASSOC);



}


if(!empty($email_to_send['id'])){
		$dbh->query("DELETE FROM emails_to_send WHERE id='".$email_to_send['id']."'");
}

$dbh->query("UPDATE app_event_appointment_times SET user_id='0',status='0' WHERE id='".$appointment['id']."'");

echo "ok";
?>