<?php


try {
    $user = "musiad";
    $pass = "musiad123";

    $dbh = new PDO('mysql:host=musiadlocalization.cc5jhd2zxzjg.eu-west-1.rds.amazonaws.com;dbname=musiadlocalization', $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

} catch (PDOException $e) {
    print "Hata!: " . $e->getMessage() . "<br/>";
    die();
}



 
//$sql = "select A.*,B.name as c_name from states as A LEFT JOIN countries as B ON A.country_id = B.id order by B.name,A.name";
//$sql = "select A.*,B.name as s_name,C.name as c_name from cities as A LEFT JOIN states as B ON A.state_id = B.id LEFT JOIN countries as C on B.country_id = C.id order by C.name , B.name,A.name";
//$sql = "select * from app_event_sectors";
$sql = "select A.*,B.name  as s_name FROM app_event_subsectors AS A LEFT JOIN app_event_sectors as B ON A.sector_id=B.id ORDER BY B.name,A.name"
?>
<table border="1">
<?php
foreach($dbh->query($sql) as $row) {
    ?>

<tr><td><?=$row['sector_id']?> - <?=$row['id']?></td><td><?=$row['name']?></td><td><?=$row['s_name']?></td></tr>

    <?php
}


///$dbh = null;

?>
</table>