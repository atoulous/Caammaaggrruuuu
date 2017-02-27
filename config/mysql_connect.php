<?php
$url = explode('/', $_SERVER[REQUEST_URI]);
if ($url[2] == 'config' && $url[3] == 'setup.php')
	include("database.php");
else
	include('config/database.php');
try {
	$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
}
catch (PDOException $Exception) {
	echo "<script>console.log('Connection failed: ".$Exception->getMessage()."');</script>";
	die();
}
