<?php
Class Photos_model
{
	public function add_base_photo($name)
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		$id = $_SESSION['id'];
		$today = date("Y-m-d H:i:s");
		$sql = $pdo->prepare("INSERT INTO $DB_NAME.photos (name, user_id, date)
			VALUES ('$name', '$id', '$today')");
		try {
			$sql->execute();
			return (TRUE);
		} catch (PDOException $e) {
			echo "Request insert photo error:".$e->getMessage()."";
			return (FALSE);
		}
	}

	public function get_all_photos()
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		$sql = $pdo->prepare("SELECT * FROM $DB_NAME.photos ORDER BY id DESC");
		try {
			$sql->execute();
			$result = $sql->fetchAll();
			return ($result);
		} catch (PDOException $e) {
			echo "Request select all photos error:".$e->getMessage()."";
			return (FALSE);
		}
	}

	public function get_user_photos($id)
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		$sql = $pdo->prepare("SELECT * FROM $DB_NAME.photos WHERE user_id = '$id'ORDER BY id DESC");
		try {
			$sql->execute();
			$result = $sql->fetchAll();
			return ($result);
		} catch (PDOException $e) {
			echo "Request select user photos error:".$e->getMessage()."";
			return (FALSE);
		}
	}

	public function get_photo($id)
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		$sql = $pdo->prepare("SELECT * FROM $DB_NAME.photos WHERE id = '$id'");
		try {
			$sql->execute();
			$result = $sql->fetch();
			return ($result);
		} catch (PDOException $e) {
			echo "Request select user photos error:".$e->getMessage()."";
			return (FALSE);
		}
	}

	public function del_base_photo($id)
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		$sql = $pdo->prepare("DELETE FROM $DB_NAME.photos WHERE 'photos.id' = '$id'");
		try {
			$sql->execute();
			return (TRUE);
		} catch (PDOException $e) {
			echo "Request insert photo error:".$e->getMessage()."";
			return (FALSE);
		}
	}
}

global $photos_model;
$photos_model = new Photos_model;
