<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');

include "connect.php";
 


$myfile = fopen("raw_data3.txt", "r") or die("Unable to open file!");
$data=  fread($myfile,filesize("raw_data3.txt"));

$array = explode("£",$data);

function fix($x){
    return ucfirst(trim(strtolower($x)));
}

?>


<table border="1" width="100%">

<?php
$table = "app_event_companies";
 $dbh->query("DELETE FROM ".$table." WHERE new='1'");
//$dbh->query("TRUNCATE ".$table."");

 $dbh->query("DELETE FROM app_event_company_subsectors WHERE new='1'");
 $dbh->query("DELETE FROM app_event_scopes WHERE new='1'");
$dbh->query("DELETE FROM app_event_company_scopes WHERE new='1'");

//$dbh->query("TRUNCATE `app_event_company_subsectors`");
//$dbh->query("TRUNCATE `app_event_scopes`");
//$dbh->query("TRUNCATE app_event_company_scopes");
//$dbh->query("TRUNCATE app_event_appointments");
///$dbh->query("TRUNCATE app_event_appointment_times");
$dbh->query("DELETE FROM app_event_appointments WHERE new='1'");
$dbh->query("DELETE FROM app_event_appointment_times WHERE new='1'");

$dbh->query("DELETE FROM users WHERE new=2");
$dbh->query("UPDATE users SET b2b='0',company_id='0' WHERE updated='2'");

$i=1;
$date=date("Y-m-d H:i:s");
$txt="";
$emailyok=0;
$email_var="";

$times = array('13:00:00','13:20:00','13:40:00','14:00:00','14:20:00','14:40:00','15:00:00','15:20:00','15:40:00','16:00:00','16:20:00','16:40:00','17:00:00','17:20:00','17:40:00','18:00:00');

foreach ($array as $item){
    $dizi  = explode("æ",$item);

?>

<tr><td><?=$i?></td><td>

        <?php

        /*
if($i==1){
    $j=0;
    foreach ($dizi as $key) {
            echo $j.":".$dizi[$j]."<br>";
$j++;
        
    }
}*/



      $ulke =$dbh->query("SELECT * FROM rainlab_location_countries WHERE name='".fix($dizi[9])."'")->fetch(PDO::FETCH_ASSOC);
      if(empty($ulke['id'])){
            $ulke =$dbh->query("SELECT * FROM rainlab_location_countries WHERE id='229'")->fetch(PDO::FETCH_ASSOC);
        ///die(fix($dizi[9]));
      }

        $sector_array=explode(",",$dizi[11]);
       $sector_id=$sector_array[0];
       $first_sector = $dbh->query("SELECT name FROM app_event_sectors WHERE id='".$sector_id."'")->fetch(PDO::FETCH_ASSOC);

       $sector_list= ",".trim(str_replace(" ","", $dizi[11])).",";

        $sql = "INSERT INTO ".$table." (name,email,phone,fax,country_id,state_id,city_id,sector_id,address,employee_count,created_at,updated_at,hall_id,stand_id,other_sector,sector_name,sector_list,new) VALUES ('".trim($dizi[4])."','".trim(strtolower($dizi[6]))."','".trim($dizi[7])."','','".$ulke['id']."','0','0','".$sector_id."','".trim($dizi[10])."','".trim($dizi[8])."','".$date."','".$date."','1','".trim($dizi[13])."','".fix($dizi[12])."','".$first_sector['name']."','".$sector_list."','1')";
     
 
        try{
                $dbh->query($sql);

                $co_id = $dbh->lastInsertId();
        } catch (PDOException $e) {
            $co_id=0;
            print "Hata!: " . $e->getMessage() . "<br/>";
            die();
        }
            echo $co_id."<br>";
            echo $sql."<br>";


  //echo $sql;

            if($co_id>0){
            $j=0;
            foreach ($sector_array as $s_id) {
                if($j>0){

                    $sql1="INSERT INTO app_event_company_subsectors (company_id,subsector_id,created_at,updated_at,new) VALUES ('".$co_id."','".$s_id."','".$date."','".$date."','1')";
                $dbh->query($sql1);

                $sec = $dbh->query("SELECT name FROM app_event_sectors WHERE id='".$s_id."'")->fetch(PDO::FETCH_ASSOC);
                $dbh->query("INSERT INTO app_event_scopes (name,is_enabled,sub_sector_id,sort_order,new) VALUES ('".$sec['name']."','1','0','0','1')");
                    $scope_id=$dbh->lastInsertId();
          $dbh->query("INSERT INTO app_event_company_scopes (company_id,scope_id,created_at,updated_at,new) VALUES ('".$co_id."','".$scope_id."','".$date."','".$date."','1')");
                      }
                    $j++;
                }//////foreach


                $rand=rand(1000000,9999999);
                $password = '$2y$10$ZPLcuJ.A6T6N3.UM8fI.JOqEYDYlu7UcSHK4pKb8TP1RF.RxtmHnm';// base64_encode($rand);
               // $password = Hash::make($rand);
                 $name_dizi = explode(" ",trim($dizi[0]));
                 $surname = str_replace($name_dizi[0], '', trim($dizi[0]));
                    $email = (!empty(trim($dizi[1]))) ? trim(strtolower($dizi[1])) : rand(100000,999999)."@tmail.com";
                    
                $varmi=$dbh->query("SELECT id,email,new FROM users WHERE email='".$email."'")->fetch();
                if(!empty($varmi['id']) && $varmi['new']==0 ) {
                    $sql_user="UPDATE users SET company_id='".$co_id."',b2b='1',updated='2' WHERE id='".$varmi['id']."'";
                    $dbh->query($sql_user);
                    $b2b_id=$varmi['id'];
                        $email_var.=$varmi['email'].":".$varmi['id'];
                } else{                

                    if($varmi['new']==2){
                        $email=$varmi['email'].rand(10,100);
                         
                    }

                $sql_user="INSERT INTO users (name,email,password, iu_telephone,is_activated,activated_at,created_at,updated_at,username,surname,company_id,b2b,new,lang) VALUES ('".fix($name_dizi[0])."','".$email."','".$password."','".trim($dizi[2])."','1','".$date."','".$date."','".$date."','".$email."','".$surname."','".$co_id."','1','2','en')";
                    $dbh->query($sql_user);
                    $b2b_id=$dbh->lastInsertId();
                }///varmi                

   ///apppp
                $dbh->query("INSERT INTO app_event_appointments (b2b_id,slot_date,created_at,updated_at,new) VALUES ('".$b2b_id."','2018-11-22','".$date."','".$date."','1')");

                $app_id= $dbh->lastInsertId();

                foreach ($times as $time) {

                    $dbh->query("INSERT INTO app_event_appointment_times (appointment_id,slot_time,user_id,status,created_at,updated_at,is_open,new) VALUES ('".$app_id."','".$time."','0','0','".$date."','".$date."','1','1')");
                }



              } ////foreach            

                    //$txt.=$sql_user.";";
         
              ///////////////user//////////////////
        ?>

    </td></tr>
<?php
$i++;
}?>
<tr><td colspan="2"><?=$emailyok?> |  <?=$email_var?></td></tr>
</table>
    <?php


fclose($myfile);