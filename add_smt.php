<?php 
 die();
 
//if($_REQUEST['key']==md5(date('YmdH'))){
if(1){

try {
    $user = "musiad";
    $pass = "musiad123";

    $dbh = new PDO('mysql:host=musiadlocalization.cc5jhd2zxzjg.eu-west-1.rds.amazonaws.com;dbname=musiadlocalization', $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

} catch (PDOException $e) {
	echo "hata";
    //print "Hata!: " . $e->getMessage() . "<br/>";
    die();
}


//$app_time = $dbh->query("SELECT * FROM app_event_appointment_times where id='".$_REQUEST['time_id']."'")->fetch();
//echo $app_time['slot_time'];
//$appointment = $dbh->query("SELECT * FROM app_event_appointments where id='".$app_time['appointment_id']."'")->fetch();
 

 
 
 
if($dbh->query("UPDATE app_event_appointment_times  SET user_id='".$_REQUEST['user_id']."' WHERE id='".$_REQUEST['time_id']."'")){
 
 	echo "ok";
$sql="SELECT A.slot_time,B.slot_date,
C.name as to_name,C.email as to_email,C.surname as to_surname, 
D.name as from_name,D.email as from_email,D.surname as from_surname,D.company_id,D.iu_telephone,D.iu_job
 FROM app_event_appointment_times AS A 
 LEFT JOIN app_event_appointments AS B ON A.appointment_id = B.id 
 LEFT JOIN users AS D ON A.user_id=D.id 
 LEFT JOIN users AS C ON B.b2b_id=C.id where A.id='".$_REQUEST['time_id']."'";

 

$data = $dbh->query($sql)->fetch();

if(!empty($data['company_id'])){
    $co = $dbh->query("SELECT * FROM app_event_companies WHERE id='".$data['company_id']."'")->fetch();
    $co_name =  $co['name'];
}else{
    $co_name = (!empty($data['iu_job']))? $data['iu_job']:"-";
}

$date = explode("-",$data['slot_date']);
$time = explode(":",$data['slot_time']);
$name_surname= $data['from_name']." ".$data['from_surname'];
$to_name = $data['to_name']." ".$data['to_surname'];
$phone = (!empty($data['iu_telephone']))?$data['iu_telephone']:"-";
$content= file_get_contents("request_mail.html");
$content= str_replace('$lang', 'en',  $content);
$content= str_replace('$name_surname',$name_surname,  $content);
$content= str_replace('$time',$time[0].":".$time[1],  $content);
$content= str_replace('$phone', $phone,  $content);
$content= str_replace('$co_name', $co_name,  $content);
$content= str_replace('$password', rand(10000,999999),  $content);
///echo $content;
$sql_insert="INSERT INTO emails_to_send (to_email,to_name,content,subject,is_sent,created_at,sent_at,app_time_id)
VALUES ('".$data['to_email']."','".$to_name."','".$content."','MÜSİAD EXPO Meeting Request','1','".date('Y-m-d H:i:s')."','','".$_REQUEST['time_id']."') ";
///echo $sql_insert;
if(!$dbh->query($sql_insert)){
     print_r($dbh->errorInfo());
}


}else{
	echo "hata";
}

}else{
	echo $_REQUEST['key'].":::".md5(date('YmdH'));
}

//echo $_REQUEST['time_id'];
?>