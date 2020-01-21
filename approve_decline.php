<?php
 
try {
    $user = "musiad";
    $pass = "musiad123";

    $dbh = new PDO('mysql:host=musiadlocalization.cc5jhd2zxzjg.eu-west-1.rds.amazonaws.com;dbname=musiadlocalization', $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

} catch (PDOException $e) {
    print "Hata!: " . $e->getMessage() . "<br/>";
    die();
}




////D  to_user C from_user

 $sql = "SELECT A.slot_time,B.slot_date,
C.name,C.surname,C.email,C.company_id,
D.name as to_name,D.email as to_email,D.surname as to_surname ,D.lang,
E.name as co_name
FROM app_event_appointment_times AS A 
LEFT JOIN app_event_appointments AS B ON A.appointment_id = B.id
 LEFT JOIN users AS C ON B.b2b_id=C.id 
 LEFT JOIN users AS D on A.user_id=D.id 
 LEFT JOIN app_event_companies AS E ON C.company_id = E.id  where A.id='".$_REQUEST['id']."'";

$data = $dbh->query($sql)->fetch();

$date = explode("-",$data['slot_date']);
$time = explode(":",$data['slot_time']);

 $to_name_surname =$data['to_name']." ".$data['to_surname'];
if($_REQUEST['approve']==1){

	$sql = "UPDATE app_event_appointment_times SET status=1 WHERE id='".$_REQUEST['id']."'";


	$txt = $data['name']." ".$data['surname'].", ".$data['co_name']." adına ".$date[2].".".$date[1].".".$date[0]."  ".$time[0].":".$time[1]." tarihi için randevu talebinizi onayladı";
	$file = "approve_mail_".$data['lang'].".html";

}else{

	$sql="UPDATE app_event_appointment_times SET user_id=0 WHERE id='".$_REQUEST['id']."'";
	//$file = "denied_mail_".$data['lang'].".html";
$file = "denied_mail_".$data['lang'].".html";

	$txt =  $data['name']." ".$data['surname'].", ".$data['co_name']." adına ".$date[2].".".$date[1].".".$date[0]."  ".$time[0].":".$time[1]." tarihi için randevu talebinizi uygun bulmadı";	

}



 

 

$content= file_get_contents($file);
$content= str_replace('$lang',$data['lang'],  $content);
$content= str_replace('$time',$time[0].":".$time[1],  $content);
$content= str_replace('$co_name', $data['co_name'],  $content);

//$content= str_replace('$user_name', 'emre.ayman@mobiwan.mobi',  $content);
//$content= str_replace('$password', rand(1000,50000) ,  $content);



 


if($dbh->query($sql)){

echo "ok";
 


 $sql_insert="INSERT INTO emails_to_send (to_email,to_name,content,subject,is_sent,created_at,sent_at) VALUES ('".$data['to_email']."','".$to_name_surname."','".$content."','MusiadExpo randevu talebi','1','".date('Y-m-d H:i:s')."','') ";
///echo $sql_insert;

//$sql_insert="INSERT INTO emails_to_send (to_email,to_name,content,subject,is_sent,created_at,sent_at) VALUES ('emre.ayman@mobiwan.mobi','".$to_name_surname."','".$content."','MusiadExpo randevu talebi','0','".date('Y-m-d H:i:s')."','') ";


if(!$dbh->query($sql_insert)){
     print_r($dbh->errorInfo());
}





}else{
	echo "hata";
}

?>