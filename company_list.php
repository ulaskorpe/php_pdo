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
$sql = "SELECT A.*,B.name AS co_name,B.stand_id FROM users AS A LEFT JOIN app_event_companies AS B ON A.company_id=B.id  WHERE A.b2b=1 AND A.company_id>0 LIMIT 0,1000";

$b2b=$dbh->query($sql);

?>
<table width="100%" border="1">
	<tr style="background-color: #acacac;color: #fff"></td><td>ŞİRKET YETKİLİSİ</td><td>ŞİRKET ADI</td><td>STANT ID</td><td>EPOSTA / GSM</td></tr>
<?php
$i=1;
foreach ($b2b as $company) {
	 
$color = ($i%2 ==0) ? "#eaeaea":"#ffffff";
	?>
<tr style="background-color: <?=$color?>"><td><?=$company['name']?> <?=$company['surname']?> </td><td><?=$company['co_name']?> , <?=$company['iu_company']?></td><td><?=$company['stand_id']?></td><td><?=$company['email']?> / <?=$company['iu_telephone']?></td></tr>
 

<?php $i++;
 }
?>

</table>