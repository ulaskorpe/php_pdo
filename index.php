<?php


include "connect.php";



$companies = $dbh->query("SELECT * FROM app_event_companies");
foreach ($companies as $co) {

$sec = $dbh->query("SELECT * FROM  app_event_sectors WHERE id='".$co['sector_id']."'")->fetch(PDO::FETCH_ASSOC);
$dbh->query("UPDATE app_event_companies SET sector_name='".trim($sec['name'])."' WHERE id='".$co['id']."'");
echo $sec['name']."<br>";
    
}



die();
$ulke =$dbh->query("SELECT * FROM countries WHERE name='Jordan'")->fetch(PDO::FETCH_ASSOC);


            var_dump($ulke);


die();
$w = "1003";
$sql = "SHOW TABLES";

foreach($dbh->query($sql) as $row) {
    $table = $row[0];

    $sql2 = "SHOW COLUMNS FROM ".$table;

        foreach ($dbh->query($sql2) as $col){
            $sql3 = "SELECT * FROM ".$table." WHERE ".$col['Field']." LIKE '%".$w."%'";
         //   echo $col[0]."<br>";
            foreach ($dbh->query($sql3) as $found){

                echo "<hr><b>".$table.":".$col['Field']."</b>";
                print_r($found);

            }

        }


}


///$dbh = null;

?>