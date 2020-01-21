<?php
//die();
 include "connect.php";

$sql = "SELECT A.*,B.name as co_name FROM users AS A LEFT JOIN app_event_companies AS B ON A.company_id=B.id WHERE A.created_at > '2018-01-01 00:00:00' AND A.is_activated='1' ORDER BY A.id DESC";
?>
<table width="100%" border="1">
<?php
$i=1;
foreach($dbh->query($sql) as $row) {
?>
    <tr><td width="10%"><?=$row['name']?> <?=$row['surname']?></td><td width="10%"><?=strtolower($row['email'])?></td><td width="10%"><?=$row['iu_telephone']?></td> <td><?=$row['iu_job']?> / <?=$row['iu_company']?>
    	
    <?php 
    if(!empty($row['co_name'])){
    ?>
	<br>B2B :<?=$row['co_name']?>
    <?php
	}
    ?>
    </td>
    	<td width="20%"><?=$row['iu_webpage']?></td><td width="20%"><?=$row['created_at']?></td></tr>
<?php
$i++;
}

?>
<tr><td colspan="5"><?=$i?></td></tr>
</table>
