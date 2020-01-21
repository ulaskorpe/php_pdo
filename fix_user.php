<?php

include "connect.php";
$users  = $dbh->query("SELECT * FROM users WHERE company_id>0");

foreach ($users as $user) {
	echo $user['name'].":".$user['company_id']."<br>";
	$dbh->query("UPDATE users SET old_company_id='".$user['company_id']."' WHERE id='".$user['id']."'");

}

?>