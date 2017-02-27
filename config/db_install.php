<?php
include('config/mysql_connect.php');
$install = $pdo->query(
	"SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$DB_NAME'"
	)->fetchColumn();
$pdo = NULL;
if (!$install)
{
	session_status() == 2 ? session_destroy() : 0;
	include_once('config/setup.php');
}
