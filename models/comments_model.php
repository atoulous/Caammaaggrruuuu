<?php
Class Comments_model
{
	public function add_base_comment($user_id, $photo_id, $photo_user_id, $text)
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		if (!$photo_user_id)
			$photo_user_id = 0;
		$today = date("Y-m-d H:i:s");
		$sql = $pdo->prepare("INSERT INTO $DB_NAME.comments (user_id, photo_id, photo_user_id, text, date)
			VALUES ('$user_id', '$photo_id', '$photo_user_id', '$text', '$today')");
		try {
			$sql->execute();
			return (TRUE);
		} catch (PDOException $e) {
			echo "Request insert comment error:".$e->getMessage()."";
			return (FALSE);
		}
	}

	public function del_base_comment($id)
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		$sql = $pdo->prepare("DELETE FROM $DB_NAME.comments WHERE id = '$id'");
		try {
			$sql->execute();
			return (TRUE);
		} catch (PDOException $e) {
			echo "Request delete comment error:".$e->getMessage()."";
			return (FALSE);
		}
	}

	public function get_photo_comments($photo_id)
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		$sql = $pdo->prepare("SELECT * FROM $DB_NAME.comments WHERE photo_id = '$photo_id' ORDER BY id ASC");
		try {
			$sql->execute();
			$result = $sql->fetchAll();
			return ($result);
		} catch (PDOException $e) {
			echo "Request select comments photo error:".$e->getMessage()."";
			return (FALSE);
		}
	}
}

global $comments_model;
$comments_model = new Comments_model;
