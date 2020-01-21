<?php

include "connect.php";
$sql = "SHOW TABLES ";
?>
<table border="1">
<?php
foreach($dbh->query($sql) as $row) {
    $table = $row[0];

  //  $sql2 = "SELECT COUNT(id) FROM ".$table;

  //  $sql2 = "SHOW COLUMNS FROM ".$table;
    //	$first = $dbh->query($sql2)->fetch();

    	$sql3="SELECT COUNT(*) FROM ".$table;
    	$count=$dbh->query($sql3)->fetch();

?>
<tr><td><?=$table?></td><td><?=$count[0]?></td></tr>
<?php

}
?>
</table>
 