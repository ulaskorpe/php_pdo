<?php


try {
    $user = "musiad";
    $pass = "musiad123";

    $dbh = new PDO('mysql:host=musiadlocalization.cc5jhd2zxzjg.eu-west-1.rds.amazonaws.com;dbname=musiadlocalization', $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

} catch (PDOException $e) {
    print "Hata!: " . $e->getMessage() . "<br/>";
    die();
}




$sql = "SELECT id FROM users WHERE b2b=1";

foreach($dbh->query($sql) as $row) {
    echo $row['id'].", ";

}


///$dbh = null;

?>