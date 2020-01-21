<?php
include "connect.php";
$co = $dbh->query("SELECT count(id) as say FROM `emails_to_send` WHERE 1")->fetch(PDO::FETCH_ASSOC);

echo $co['say'];



?>