<?php
Class Likes_model
{
	public function add_base_like($user_id, $photo_id, $photo_user_id)
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		if (!$photo_user_id)
			$photo_user_id = 0;
		$sql = $pdo->prepare("INSERT INTO $DB_NAME.likes (user_id, photo_id, photo_user_id)
			VALUES ('$user_id', '$photo_id', '$photo_user_id')");
		try {
			$sql->execute();
			return (TRUE);
		} catch (PDOException $e) {
			echo "Request insert like error:".$e->getMessage()."";
			return (FALSE);
		}
	}
	public function del_base_like($like_id)
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		$sql = $pdo->prepare("DELETE FROM $DB_NAME.likes WHERE id = '$like_id'");
		try {
			$sql->execute();
			return (TRUE);
		} catch (PDOException $e) {
			echo "Request insert like error:".$e->getMessage()."";
			return (FALSE);
		}
	}
	public function get_photo_likes($photo_id)
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		$sql = $pdo->prepare("SELECT * FROM $DB_NAME.likes WHERE photo_id = '$photo_id'");
		try {
			$sql->execute();
			$result = $sql->fetchAll();
			return ($result);
		} catch (PDOException $e) {
			echo "Request select likes photo error:".$e->getMessage()."";
			return (FALSE);
		}
	}
	public function get_user_like($photo_id, $user_id)
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		$sql = $pdo->prepare("SELECT * FROM $DB_NAME.likes WHERE photo_id = '$photo_id' AND user_id = '$user_id'");
		try {
			$sql->execute();
			$result = $sql->fetch();
			return ($result);
		} catch (PDOException $e) {
			echo "Request select like user error:".$e->getMessage()."";
			return (FALSE);
		}
	}
}

global $likes_model;
$likes_model = new Likes_model;
