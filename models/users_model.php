<?php
Class Users_model
{
	public function login($login, $pwd)
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		$sql = $pdo->prepare("SELECT * FROM $DB_NAME.users WHERE login = '$login' OR email = '$login'");
		try {
			$sql->execute();
			$result = $sql->fetch();
		}
		catch (PDOException $e) {
			echo "Request login error: ".$e->getMessage()."";
		}
		if ($result)
		{
			if ($result['pwd'] == hash('whirlpool', $pwd))
			{
				$_SESSION['connect'] = 'yes';
				$_SESSION['id'] = $result['id'];
				$_SESSION['login'] = $result['login'];
				$_SESSION['email'] = $result['email'];
				$_SESSION['admin'] = $result['admin'];
				return ($result);
			}
			else
			{
				$_SESSION['alert'] = "Mot de passe incorrecte";
				return (FALSE);
			}
		}
		else
		{
			$_SESSION['alert'] = "Identifiant inconnu";
			return (FALSE);
		}
	}

	public function subscribe($login, $email, $pwd)
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		$today = date("Y-m-d H:i:s");
		$sql = $pdo->prepare("INSERT INTO $DB_NAME.users (login, email, pwd, date)
			VALUES ('$login', '$email', '$pwd', '$today')");
		try {
			$result = $sql->execute();
		}
		catch (PDOException $e) {
			echo "Register member error: ".$e->getMessage()."";
		}
		if ($result)
		{
			$_SESSION['connect'] = 'yes';
			$_SESSION['id'] = $pdo->lastInsertId();
			$_SESSION['login'] = $login;
			$_SESSION['email'] = $email;
			return ($result);
		}
		else
			return (FALSE);
	}

	public function checkifexists($login, $email)
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		$sql = $pdo->prepare("SELECT * FROM $DB_NAME.users WHERE login = '$login' OR email = '$email'");
		try {
			$sql->execute();
			$result = $sql->fetch();
		}
		catch (PDOException $e) {
			echo "Request SQL error: ".$e->getMessage()."";
		}
		if ($result)
		{
			if ($result['login'] == $login)
				$_SESSION['alert'] = "Login déjà existant";
			if ($result['email'] == $email)
			{
				if ($_SESSION['alert'])
					$_SESSION['alert'] = "Compte déjà existant";
				else
					$_SESSION['alert'] = "Email déjà existant";
			}
			return ($result);
		}
		else
			return (FALSE);
	}
	
	public function checkpwd($old_pwd, $id)
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		$sql = $pdo->prepare("SELECT * FROM $DB_NAME.users WHERE id = '$id'");
		try {
			$sql->execute();
			$result = $sql->fetch();
		} catch (PDOException $e) {
			echo "Request checkpwd error: ".$e->getMessage()."";
		}
		if ($result['pwd'] != $old_pwd)
			return (TRUE);
		else
			return (FALSE);
	}

	public function get_user_infos($id)
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		$sql = $pdo->prepare("SELECT * FROM $DB_NAME.users WHERE id = '$id'");
		try {
			$sql->execute();
			$result = $sql->fetch();
		}
		catch (PDOException $e) {
			echo "Request get user infos error: ".$e->getMessage()."";
		}
		if ($result)
			return ($result);
		else
			return (FALSE);
	}

	public function modif_user_infos($id, $login, $email, $pwd)
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		$sql = $pdo->prepare("UPDATE $DB_NAME.users SET
			login = '$login',
			email = '$email',
			pwd = '$pwd'
			WHERE id = '$id'");
		try {
			$sql->execute();
			return (TRUE);
		}
		catch (PDOException $e) {
			echo "Request modif user infos error: ".$e->getMessage()."";
			return (FALSE);
		}
	}

	public function delete_user_base($id)
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		$sql = $pdo->prepare("DELETE FROM $DB_NAME.users WHERE id = '$id'");
		try {
			$sql->execute();
			return (TRUE);
		} catch (PDOException $e) {
			echo 'Request delete user error: '.$e->getMessage().'';
			return (FALSE);
		}
	}

	public function get_all_users()
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		$sql = $pdo->prepare("SELECT * FROM $DB_NAME.users ORDER BY id ASC");
		try {
			$sql->execute();
			$result = $sql->fetchAll();
		}
		catch (PDOException $e) {
			echo "Request get all user error: ".$e->getMessage()."";
		}
		if ($result)
			return ($result);
		else
			return (FALSE);
	}
}

global $users_model;
$users_model = new Users_model;
