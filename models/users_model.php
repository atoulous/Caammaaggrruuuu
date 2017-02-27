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
			echo "Request SQL error: ".$e->getMessage()."";
		}
		if ($result && $result['pwd'] == hash('whirlpool', $pwd))
		{
			$_SESSION['connect'] = 'yes';
			$_SESSION['id'] = $result['id'];
			$_SESSION['login'] = $result['login'];
			$_SESSION['admin'] = $result['admin'];
			return ($result);
		}
		else
			return (FALSE);
	}
	public function subscribe($login, $email, $pwd)
	{
		global $DB_NAME;

		require('config/mysql_connect.php');
		$sql = $pdo->prepare("INSERT INTO $DB_NAME.users (login, email, pwd)
			VALUES ('$login', '$email', '$pwd')");
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
			return (TRUE);
		}
		else
			return (FALSE);
	}
}

global $users_model;
$users_model = new Users_model;
