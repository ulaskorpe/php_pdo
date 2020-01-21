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
$sql = "SELECT A.*,B.name AS co_name,B.stand_id FROM users AS A LEFT JOIN app_event_companies AS B ON A.company_id=B.id  WHERE A.b2b=1 AND A.company_id>0  ORDER BY B.name";

$b2b=$dbh->query($sql);

?>
<table width="100%" border="1">
 
<?php
$i=1;
$j=0;
foreach ($b2b as $company) {
	$sql2="SELECT A.*,C.name as u_name,C.surname as u_surname,C.email as u_email,C.iu_telephone as u_phone,C.iu_company as u_company FROM app_event_appointment_times AS A LEFT JOIN app_event_appointments AS B ON A.appointment_id=B.id LEFT JOIN users AS C ON A.user_id=C.id WHERE A.user_id>0 AND A.status=1 AND B.b2b_id='".$company['id']."' ORDER BY A.slot_time";
	$appointments = $dbh->query($sql2);

	 
		
		
			foreach ($appointments as $app) {
$color = ($j%2 ==0) ? "#cacaca":"#ffffff";
				 
	?>
<tr style="background-color: <?=$color?>;padding-left: 20px"> 

<td>
	<div style="margin-left-left: 20px">
<b>Kullanıcı :</b><br>
<ul>
	<li><?=$app['u_name']?> <?=$app['u_surname']?></li>
	<li><?=$app['u_email']?></li>
	<li><?=$app['u_phone']?></li>
	<li><?=$app['u_company']?></li>
</ul>
<br>
<b>B2B</b>
<ul>
	<li><?=$company['name']?> <?=$company['surname']?></li>
	<li><?=$company['email']?></li>
	<li><?=$company['iu_telephone']?></li>
	<li><?=$company['co_name']?> , <?=$company['iu_company']?></li>
	<li><?=$company['stand_id']?></li>
	<li><?=$app['slot_time']?></li>
</ul>
</div>
</td>


</tr>

<?php $j++; }


 ?>
 

<?php $i++;
 }
?>

</table>