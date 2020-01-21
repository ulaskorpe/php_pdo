<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');

include "connect.php";
 


$myfile = fopen("stands.txt", "r") or die("Unable to open file!");
$data=  fread($myfile,filesize("raw_data3.txt"));

 
$array = explode("£",$data);

function fix($x){
    return ucfirst(trim(strtolower($x)));
}

$i=1;
foreach ($array as $item) {
	$dizi=explode("@",$item);
	$co = $dbh->query("SELECT * FROM `app_event_companies` where id='".$i."'")->fetch(PDO::FETCH_ASSOC);
	
	echo $item."<br>";
	echo $co['stand_id']."@".$co['name']."<hr>";
	$dbh->query("UPDATE app_event_companies SET stand_id='".trim($dizi[0])."' WHERE id='".$i."'");
	$i++;
}



?>