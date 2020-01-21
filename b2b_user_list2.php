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
$sql = "SELECT A.*,B.name AS co_name,B.stand_id FROM users AS A LEFT JOIN app_event_companies AS B ON A.company_id=B.id  WHERE b2b=1 AND company_id>0 LIMIT 0,1000";

$b2b=$dbh->query($sql);

?>
<table width="100%" border="1">
<tr style="background-color: #acacac;color: #fff"></td><td>ŞİRKET YETKİLİSİ</td><td>ŞİRKET ADI</td><td>STANT ID</td><td>EPOSTA / GSM</td>
<td>SAAT</td><td>GÖRÜŞMECİ</td></tr>	
<?php
$i=1;
$j=0;
foreach ($b2b as $company) {
	$sql2="SELECT A.*,C.name as u_name,C.surname as u_surname,C.email as u_email,C.iu_telephone as u_phone,C.iu_company as u_company FROM app_event_appointment_times AS A LEFT JOIN app_event_appointments AS B ON A.appointment_id=B.id LEFT JOIN users AS C ON A.user_id=C.id WHERE A.user_id>0 AND A.status=1 AND B.b2b_id='".$company['id']."' ORDER BY A.slot_time";
	$appointments = $dbh->query($sql2);

	 
		
		
			foreach ($appointments as $app) {
$color = ($j%2 ==0) ? "#cacaca":"#ffffff";
				 
	?>
<tr style="background-color: <?=$color?>"></td><td width="150"><?=$company['name']?> <?=$company['surname']?> </td><td width="160"><?=$company['co_name']?> , <?=$company['iu_company']?></td><td><?=$company['stand_id']?></td><td><?=$company['email']?> / <?=$company['iu_telephone']?></td>
<td><?=$app['slot_time']?></td><td><?=$app['u_name']?> <?=$app['u_surname']?>, <?=$app['u_email']?>, <?=$app['u_phone']?>, <?=$app['u_company']?></td>

</tr>

<?php $j++; }


 ?>
 

<?php $i++;
 }
?>

</table>