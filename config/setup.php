<?php
session_destroy();
include_once('mysql_connect.php');

$sql = "DROP DATABASE IF EXISTS $DB_NAME;
		CREATE DATABASE IF NOT EXISTS $DB_NAME";
try {
	$pdo->query($sql);
}
catch (PDOException $Exception) {
	echo 'Creation failed:' .$Exception->getMessage();
	die();
}
echo 'Creation db_camagru succeeded<br/>';
$SESSION_exist = 1;
