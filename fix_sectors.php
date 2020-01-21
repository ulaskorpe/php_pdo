<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');

include "connect.php";


$companies = $dbh->query("SELECT * FROM app_event_companies");
foreach ($companies as $company) {
	/*$sec=$dbh->query("SELECT * FROM app_event_sectors WHERE id='".$company['sector_id']."'")->fetch(PDO::FETCH_ASSOC);
	echo $company['name'].":".$sec['name']."<br>";
	$dbh->query("UPDATE app_event_companies SET sector_name='".$sec['name']."' WHERE id='".$company['id']."'");*/

	/*$sec_dizi=explode(",",$company['sector_list']);
	echo $company['name']."<br>";
	$txt="";
	foreach ($sec_dizi as $s_id) {
		if(!empty($s_id)){
		$sec=$dbh->query("SELECT * FROM app_event_sectors WHERE id='".$s_id."'")->fetch(PDO::FETCH_ASSOC);
		//echo $s_id.":".$sec['name']."<br>";
		$txt.=",".$sec['name'];
		}
	}*/

$txt = $company['all_sectors'].",".$company['name'].",".$company['other_sector'].",".$company['sector_name'];


 //$dbh->query("UPDATE app_event_companies SET all_sectors='".$txt."' WHERE id='".$company['id']."'");
echo $txt;
echo "<hr>";


}



die();
$myfile = fopen("raw_data2.txt", "r") or die("Unable to open file!");
$data=  fread($myfile,filesize("raw_data2.txt"));
$array = explode("£",$data);

?>


<table border="1" width="100%">

<?php
$i=1;
foreach ($array as $item){
	
    $dizi  = explode("æ",$item);
    $name=trim($dizi[4]);

    $co=$dbh->query("SELECT * FROM app_event_companies WHERE id='".$i."'")->fetch(PDO::FETCH_ASSOC);
 		$dbh->query("UPDATE app_event_companies SET sector_list=',".str_replace(" ","",trim($dizi[11])).",' WHERE id='".$i."'");

?>
<tr><td><?=$name?> | <?=$co['id']?><br> <?=$co['name']?></td><td><?=$dizi[11]?><br>
<?=$co['sector_list']?>
</td></tr>
<?php
$i++;
}

?>
</table>