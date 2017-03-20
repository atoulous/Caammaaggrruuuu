<?php
Class User
{
	function __construct()
	{
		require_once('models/users_model.php');
	}
	public function index()
	{
		global $base_url;
		global $users_model;

		if ($_SESSION['connect'] == 'yes')
		{
			Home::index();
			exit;
		}
		if (!$_POST['submit'])
			include('views/login_view.php');
		else
		{
			if (!$_POST['login'] || !$_POST['pwd'])
			{
				$alert = "Champ manquant";
				include('views/login_view.php');
				exit;
			}
			$pattern_login = "/.[a-zA-Z0-9@._-]{1,}/";
			$pattern_pwd = "/.[a-zA-Z0-9]{5,}/";
			$login = $_POST['login'];
			$pwd = $_POST['pwd'];
			if (!preg_match($pattern_login, $login) || !preg_match($pattern_pwd, $pwd))
			{
				$alert = "don't hack me bro";
				include('views/login_view.php');
				exit;
			}
			if ($users_model->login($login, $pwd))
			{
				$_SESSION['alert'] = "Bonjour $login !";
				header("Location: $base_url");
			}
			else
			{
				$alert = $_SESSION['alert'];
				$_SESSION['alert'] = NULL;
				include('views/login_view.php');
				exit;
			}
		}
	}
	public function subscribe()
	{
		global $base_url;
		global $users_model;

		if ($_SESSION['connect'] == 'yes')
		{
			Home::index();
			exit;
		}
		if (!$_POST['submit'])
			include('views/subscribe_view.php');
		else
		{
			$login = $_POST['login'];
			$email = $_POST['email'];
			$pwd = $_POST['pwd'] ? hash('whirlpool', $_POST['pwd']) : $pwd;
			$pwd2 = $_POST['pwd2'] ? hash('whirlpool', $_POST['pwd2']) : $pwd2;
			$pattern_login = "/.[a-zA-Z0-9]{1,}/";
			$pattern_email = "/.[a-zA-Z0-9@._-]{2,}/";
			$pattern_pwd = "/.[a-zA-Z0-9]{5,}/";
			if (!$login || !$email || !$pwd || !$pwd2)
			{
				$alert = "Tout n'est pas rempli";
				include('views/subscribe_view.php');
				exit;
			}
			if (!preg_match($pattern_login, $login) || !preg_match($pattern_email, $email)
				|| !preg_match($pattern_pwd, $pwd))
			{
				$alert = "don't hack me bro";
				include('views/login_view.php');
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
				$alert = "Mots de passe différents";
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
				$message = '
					<html>
					<body>
					<h3>Bienvenue sur Camagru '.$login.'! Snap, commente, like!</h3>
					<a href="http://localhost:8080'.$base_url.'">Camagru</a></br>
					</body>
					</html>';
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'From: camagru@no-reply.com' . "\r\n";
				$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
				mail($email, "Inscription Camagru", $message, $headers);
				header("Location: $base_url");
			}
			else
				include('views/subscribe_view.php');
		}
	}
	public function logout()
	{
		global $base_url;

		if (!$_SESSION['connect'])
		{
			User::index();
			exit;
		}
		$_SESSION = array();
		if (ini_get("session.use_cookies"))
		{
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]);
		}
		session_destroy();
		header("Location: $base_url");
	}

	public function user_infos()
	{
		global $base_url;

		if (!$_SESSION['connect'])
		{
			User::index();
			exit;
		}
		else
		{
			echo ($_SESSION['alert']);
			$_SESSION['alert'] = NULL;
			$url = explode('/', $_SERVER[REQUEST_URI]);
			$user_id = $url[4];
			if ($user_id && $_SESSION['admin'] && $user_id != $_SESSION['id'])
				User::admin_user($user_id);
			else if (!$user_id || ($user_id == $_SESSION['id']))
			{
				$login = $_SESSION['login'];
				$email = $_SESSION['email'];
				include('views/header_view.php');
				include('views/user_infos_view.php');
				include('views/footer_view.php');
			}
			else
			{
				header('Location: '.$base_url.'user/list_users');
			}
		}
	}

	public function admin_user($user_id)
	{
		global $base_url;

		if (!$_SESSION['connect'])
		{
			User::index();
			exit;
		}
		echo ($_SESSION['alert']);
		$_SESSION['alert'] = NULL;
		if ($user_id && $_SESSION['admin'])
		{
			$user = Users_model::get_user_infos($user_id);
			$login = $user['login'];
			$email = $user['email'];
			include('views/header_view.php');
			include('views/admin_modif_view.php');
			include('views/footer_view.php');
			exit;
		}
	}

	public function admin_modif()
	{
		global $base_url;

		if (!$_SESSION['connect'])
		{
			User::index();
			exit;
		}
		if (!$_POST['submit'])
			header("Location: $base_url");
		$user_id = $_POST['user_id'];
		$user = Users_model::get_user_infos($user_id);
		$login = $user['login'];
		$email = $user['email'];
		$new_login = $_POST['login'];
		$new_email = $_POST['email'];
		$new_pwd = $_POST['pwd'] ? hash('whirlpool', $_POST['pwd']) : $new_pwd;
		$new_pwd2 = $_POST['pwd2'] ? hash('whirlpool', $_POST['pwd2']) : $new_pwd2;
		$pattern_login = "/.[a-zA-Z0-9]{1,}/";
		$pattern_email = "/.[a-zA-Z0-9@._-]{2,}/";
		$pattern_pwd = "/.[a-zA-Z0-9]{5,}/";
		if (!$new_login || !$new_email || !$new_pwd || !$new_pwd2)
		{
			$alert = "Tout n'est pas rempli";
			include('views/header_view.php');
			include('views/admin_modif_view.php');
			include('views/footer_view.php');
			exit;
		}
		if (!preg_match($pattern_login, $new_login) || !preg_match($pattern_email, $new_email)
			|| !preg_match($pattern_pwd, $new_pwd) || !preg_match($pattern_pwd, $new_pwd2))
		{
			$alert = "don't hack me bro";
			include('views/login_view.php');
			exit;
		}
		else if (!filter_var($new_email, FILTER_VALIDATE_EMAIL))
		{
			$alert = "Le mail est invalide";
			include('views/header_view.php');
			include('views/admin_modif_view.php');
			include('views/footer_view.php');
			exit;
		}
		else if ($new_pwd != $new_pwd2)
		{
			$alert = "Nouveaux mots de passe différents";
			include('views/header_view.php');
			include('views/admin_modif_view.php');
			include('views/footer_view.php');
			exit;
		}
		else if ($new_login != $login
			&& Users_model::checkifexists($new_login, "none"))
		{
			$alert = $_SESSION['alert'];
			$_SESSION['alert'] = NULL;
			include('views/header_view.php');
			include('views/admin_modif_view.php');
			include('views/footer_view.php');
			exit;
		}
		else if ($new_email != $email
			&& Users_model::checkifexists("none", $new_email))
		{
			$alert = $_SESSION['alert'];
			$_SESSION['alert'] = NULL;
			include('views/header_view.php');
			include('views/admin_modif_view.php');
			include('views/footer_view.php');
			exit;
		}
		if (Users_model::modif_user_infos($user_id, $new_login, $new_email, $new_pwd))
		{
			$login = $new_login;
			$email = $new_email;
			$message = '
				<html>
					<body>
					<h3>Votre compte Camagru '.$new_login.' a bien été modifié!</h3>
					<a href="http://localhost:8080'.$base_url.'">Camagru</a></br>
					</body>
				</html>';
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'From: camagru@no-reply.com' . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			mail($new_email, "Modification Camagru", $message, $headers);
			$alert = "Modification réussi";
			include('views/header_view.php');
			include('views/admin_modif_view.php');
			include('views/footer_view.php');
			exit;
		}
		else
		{
			$alert = "Erreur?";
			include('views/header_view.php');
			include('views/admin_modif_view.php');
			include('views/footer_view.php');
			exit;
		}
	}

	public function modif()
	{
		global $base_url;
		global $users_model;
		global $DB_NAME;

		if (!$_SESSION['connect'])
		{
			User::index();
			exit;
		}
		if (!$_POST['submit'])
			header("Location: $base_url");
		$id = $_SESSION['id'];
		$new_login = $_POST['login'];
		$new_email = $_POST['email'];
		$old_pwd = $_POST['old_pwd'] ? hash('whirlpool', $_POST['old_pwd']) : $old_pwd;
		$new_pwd = $_POST['pwd'] ? hash('whirlpool', $_POST['pwd']) : $new_pwd;
		$new_pwd2 = $_POST['pwd2'] ? hash('whirlpool', $_POST['pwd2']) : $new_pwd2;
		$pattern_login = "/.[a-zA-Z0-9]{1,}/";
		$pattern_email = "/.[a-zA-Z0-9@._-]{2,}/";
		$pattern_pwd = "/.[a-zA-Z0-9]{5,}/";
		if (!$new_login || !$new_email || !$old_pwd || !$new_pwd || !$new_pwd2)
		{
			$alert = "Tout n'est pas rempli";
			include('views/header_view.php');
			include('views/user_infos_view.php');
			include('views/footer_view.php');
			exit;
		}
		if (!preg_match($pattern_login, $new_login) || !preg_match($pattern_email, $new_email)
			|| !preg_match($pattern_pwd, $old_pwd) || !preg_match($pattern_pwd, $new_pwd)
			|| !preg_match($pattern_pwd, $new_pwd2))
		{
			$alert = "don't hack me bro";
			include('views/login_view.php');
			exit;
		}
		else if (!filter_var($new_email, FILTER_VALIDATE_EMAIL))
		{
			$alert = "Le mail est invalide";
			include('views/header_view.php');
			include('views/user_infos_view.php');
			include('views/footer_view.php');
			exit;
		}
		else if ($users_model->checkpwd($old_pwd, $id))
		{
			$alert = "Ancien mot de passe incorrecte";
			include('views/header_view.php');
			include('views/user_infos_view.php');
			include('views/footer_view.php');
			exit;
		}
		else if ($new_pwd != $new_pwd2)
		{
			$alert = "Nouveaux mots de passe différents";
			include('views/header_view.php');
			include('views/user_infos_view.php');
			include('views/footer_view.php');
			exit;
		}
		else if ($new_login != $_SESSION['login']
			&& $users_model->checkifexists($new_login, "none"))
		{
			$alert = $_SESSION['alert'];
			$_SESSION['alert'] = NULL;
			include('views/header_view.php');
			include('views/user_infos_view.php');
			include('views/footer_view.php');
			exit;
		}
		else if ($new_email != $_SESSION['email']
			&& $users_model->checkifexists("none", $new_email))
		{
			$alert = $_SESSION['alert'];
			$_SESSION['alert'] = NULL;
			include('views/header_view.php');
			include('views/user_infos_view.php');
			include('views/footer_view.php');
			exit;
		}
		if ($users_model->modif_user_infos($id, $new_login, $new_email, $new_pwd))
		{
			$_SESSION['login'] = $new_login;
			$_SESSION['email'] = $new_email;
			$message = '
				<html>
					<body>
					<h3>Votre compte Camagru '.$new_login.' a bien été modifié!</h3>
					<a href="http://localhost:8080'.$base_url.'">Camagru</a></br>
					</body>
				</html>';
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'From: camagru@no-reply.com' . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			mail($new_email, "Modification Camagru", $message, $headers);
			$alert = "Modification réussi";
			include('views/header_view.php');
			include('views/user_infos_view.php');
			include('views/footer_view.php');
			exit;
		}
		else
		{
			$alert = "Erreur?";
			include('views/header_view.php');
			include('views/user_infos_view.php');
			include('views/footer_view.php');
			exit;
		}
	}
	public function delete_user()
	{
		global $base_url;

		if (!$_SESSION['connect'])
		{
			User::index();
			exit;
		}
		if (!$_POST['submit'])
			header("Location: $base_url");
		$id = $_POST['user_id'];
		if ($id == '1')
		{
			$_SESSION['alert'] = "Impossible de delete l'administrateur";
			header("Location: $base_url");
		}
		else
		{
			if (Users_model::delete_user_base($id))
			{
				if ($_SESSION['id'] == $id)
				{
					$message = '
						<html>
						<body>
						<h3>Votre compte Camagru '.$_SESSION['login'].' a bien été supprimé</h3>
						<a href="http://localhost:8080'.$base_url.'">Camagru</a></br>
						</body>
						</html>';
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'From: camagru@no-reply.com' . "\r\n";
					$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
					mail($_SESSION['email'], "Delete Camagru", $message, $headers);
					User::logout();
				}
				else
					header("Location: $base_url");
			}
			else
			{
				$_SESSION['alert'] == "Erreur?";
				header("Location: $base_url");
			}
		}
	}

	public function list_users()
	{
		global $base_url;

		if (!$_SESSION['connect'])
		{
			User::index();
			exit;
		}
		echo ($_SESSION['alert']);
		$_SESSION['alert'] = NULL;
		include('views/header_view.php');
		$users = Users_model::get_all_users();
		include('views/list_users_view.php');
		include('views/footer_view.php');
	}

	public function reset_pwd()
	{
		global $base_url;

		if ($_POST['submit'] && $_POST['login'])
		{
			$login = $_POST['login'];
			$pattern_email = "/.[a-zA-Z0-9@._-]{1,}/";
			if (!preg_match($pattern_email, $login))
			{
				$alert = "don't hack me bro";
				include('views/reset_pwd_view.php');
				exit;
			}
			if (!$user = Users_model::checkifexists($login, ""))
				if (!$user = Users_model::checkifexists("", $login))
				{
					$alert = "Inconnu au bataillon";
					include('views/reset_pwd_view.php');
					exit;
				}
			$pwd = uniqid();
			if (Users_model::modif_user_infos($user['id'], $user['login'], $user['email'], hash('whirlpool', $pwd)))
			{
				$message = '
					<html>
					<body>
					<h3>Votre nouveau mot de passe '.$user['login'].'</h3>
					<p>Mot de passe : '.$pwd.'</p>
					<a href="http://localhost:8080'.$base_url.'">Camagru</a></br>
					</body>
					</html>';
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'From: camagru@no-reply.com' . "\r\n";
				$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
				$mail = $user['email'];
				mail($mail, "Camagru", $message, $headers);
				$alert = "Nouveau mot de passe envoyé à $mail";
				include('views/login_view.php');
			}
			else
			{
				$alert = "Error :?";
				include('views/login_view.php');
			}
		}
		else
			include('views/reset_pwd_view.php');
	}
}

global $user;
$user = new User;
