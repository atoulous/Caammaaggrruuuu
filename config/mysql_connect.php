<?php
try {
	$pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
	echo "Connection succeeded to $DB_NAME<br/>";
}
catch (PDOException $Exception) {
	echo 'Connection failed:' .$Exception->getMessage();
	die();
}
