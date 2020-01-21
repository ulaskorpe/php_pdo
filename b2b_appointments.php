<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');
include "connect.php";

/*
$companies = $dbh->query("SELECT * FROM app_event_companies");
foreach ($companies as $company) {
	
	 $user = $dbh->query("SELECT * FROM users WHERE company_id='".$company['id']."'")->fetch(PDO::FETCH_ASSOC);
	 if(empty($user['id'])){
	 	echo $company['name']."<br>";
	 }

}


die();*/
//$sql = "SELECT A.*,B.name AS co_name,B.stand_id FROM users AS A LEFT JOIN app_event_companies AS B ON A.company_id=B.id  WHERE A.b2b=1 AND A.company_id>0 LIMIT 0,1000";
$sql = "SELECT A.slot_time,B.name,B.surname,B.email,B.iu_job,B.iu_telephone,D.name as c_name,D.surname as c_surname,D.email as c_email,D.iu_job as c_job,D.iu_telephone as c_phone,E.name as co_name,E.phone as co_phone FROM app_event_appointment_times AS A LEFT JOIN users AS B ON A.user_id=B.id
	LEFT JOIN app_event_appointments AS C ON A.appointment_id=C.id LEFT JOIN users AS D ON C.b2b_id=D.id
	LEFT JOIN app_event_companies as E ON D.company_id=E.id WHERE A.user_id>0";

$b2b=$dbh->query($sql);

?>
<table width="100%" border="1">
	<tr style="background-color: #acacac;color: #fff"></td><td>Görüşmek İsteyen</td><td>İletişim</td><td>Şirket/İş</td><td>Görüşmek İstenilen Şirket</td><td>Şirketin Temsilcisi</td><td>Saat</td></tr>
<?php
$i=1;
foreach ($b2b as $company) {
	 
$color = ($i%2 ==0) ? "#eaeaea":"#ffffff";
	?>
<tr style="background-color: <?=$color?>">
	<td><?=$company['name']?> <?=$company['surname']?> </td>
	<td><?=$company['email']?> / <?=$company['iu_telephone']?></td>
	<td><?=$company['iu_job']?></td>
	<td><?=$company['co_name']?></td>
	<td><?=$company['c_name']?> <?=$company['c_surname']?> <br> <?=$company['c_email']?> / <?=$company['c_phone']?></td>
	<td><?=$company['slot_time']?></td>
	</tr>
 

<?php $i++;
 }
?>

</table>