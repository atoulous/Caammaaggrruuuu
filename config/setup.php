<?php
include('mysql_connect.php');
$sql = $pdo->prepare("DROP DATABASE IF EXISTS $DB_NAME;
		CREATE DATABASE IF NOT EXISTS $DB_NAME;
		USE $DB_NAME");
try {
	$sql->execute();
} catch (PDOException $Exception) {
	echo "Creation failed: ".$Exception->getMessage()."";
	die();
}
echo "<script>console.log('db_camagru well created and now used');</script>";

$sql = $pdo->prepare("
	CREATE TABLE users (
		id INT PRIMARY KEY AUTO_INCREMENT,
		login VARCHAR(255),
		email VARCHAR(255),
		pwd VARCHAR(255),
		date DATETIME,
		active VARCHAR(255),
		admin INT);
	CREATE TABLE photos (
		id INT PRIMARY KEY AUTO_INCREMENT,
		name VARCHAR(255),
		date DATETIME,
		extension VARCHAR(255),
		user_id INT);
	CREATE TABLE likes (
		id INT PRIMARY KEY AUTO_INCREMENT,
		user_id INT,
		photo_id INT,
		photo_user_id INT);
	CREATE TABLE comments (
		id INT PRIMARY KEY AUTO_INCREMENT,
		user_id INT,
		photo_id INT,
		photo_user_id INT,
		date DATETIME,
		text VARCHAR(255));");
try {
	$sql->execute();
} catch (PDOException $Exception) {
	echo "Failed to create tables: ".$Exception->getMessage()."";
	die();
}
echo "<script>console.log('Tables well created');</script>";

$user = 'atoulous';
$pwd = hash('whirlpool', 'admin1');
$email = 'atoulous@student.42.fr';
$today = date("Y-m-d H:i:s");
$admin = 1;
$sql = $pdo->prepare("INSERT INTO users (login, pwd, email, admin, date, active)
		VALUES ('$user', '$pwd', '$email', '$admin', '$today', 'yes')");
try {
	$sql->execute();
} catch (PDOException $Exception) {
	echo "Failed to create admin: ".$Exception->getMessage()."";
	die();
}
echo "<script>console.log('atoulous admin created');</script>";
echo "<script>console.log('Camagru is now install');</script>";
$pdo = NULL;
