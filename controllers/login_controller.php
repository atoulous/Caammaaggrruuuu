<?php
Class Login
{
	function __construct()
	{
		require_once('models/users_model.php');
	}
	public function index()
	{
		global $base_url;
		global $users_model;

		if (!$_POST['submit'] || !$_POST['login'] || !$_POST['pwd'])
		{
			include('views/login_view.php');
		}
		else
		{
			$login = $_POST['login'];
			$pwd = $_POST['pwd'];
			if ($users_model->login($login, $pwd))
			{
				$_SESSION['alert'] = "Bonjour $login !";
				header("Location: $base_url");
			}
			else
				include('views/login_view.php');
		}
	}
	public function subscribe()
	{
		global $base_url;
		global $users_model;

		if (!$_POST['submit'])
			include('views/subscribe_view.php');
		else
		{
			$login = $_POST['login'];
			$email = $_POST['email'];
			$pwd = $_POST['pwd'] ? hash('whirlpool', $_POST['pwd']) : $pwd;
			$pwd2 = $_POST['pwd2'] ? hash('whirlpool', $_POST['pwd2']) : $pwd2;
			if (!$login || !$email || !$pwd || !$pwd2)
			{
				$alert = "Tout n'est pas rempli";
				include('views/subscribe_view.php');
				exit;
			}
			else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$alert = "Le mail est invalide";
				include('views/subscribe_view.php');
				exit;
			}
			else if ($pwd != $pwd2)
			{
				$alert = "Reconfirmez le mot de passe";
				include('views/subscribe_view.php');
				exit;
			}
			else if ($users_model->checkifexists($login, $email))
			{
				$alert = $_SESSION['alert'];
				$_SESSION['alert'] = NULL;
				include('views/subscribe_view.php');
				exit;
			}
			if ($users_model->subscribe($login, $email, $pwd))
			{
				$_SESSION['alert'] = "Bienvenue jeune padawan $login !";
				$message = "Bienvenue sur Camagru $login! Snap, commente, like: commence l'aventure dès maintenant!";
				mail($email, "Inscription Camagru", $message);
				header("Location: $base_url");
			}
			else
				include('views/subscribe_view.php');
		}
	}
	public function logout()
	{
		global $base_url;

		session_status() == 2 ? session_destroy() : 0;
		$_SESSION['connect'] = 'no';
		header("Location: $base_url");
	}
}
global $login;
$login = new Login;
