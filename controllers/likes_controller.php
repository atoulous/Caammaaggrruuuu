<?php
class Like
{
	public function index()
	{
		if (!$_SESSION['connect'])
		{
			Home::index();
			exit;
		}
	}

	public function add_like()
	{
		global $base_url;

		if (!$_SESSION['connect'])
		{
			Home::index();
			exit;
		}
		if ($_POST['submit'])
		{
			$user_id = $_SESSION['id'];
			$photo_user_id = $_POST['photo_user_id'];
			$photo_id = $_POST['photo_id'];
			if (Likes_model::add_base_like($user_id, $photo_id, $photo_user_id) && $_SESSION['id'] != $photo_user_id)
			{
				$user_photo = Users_model::get_user_infos($photo_user_id);
				$login = $_SESSION['login'];
				$message = '
					<html>
					<head>
					</head>
					<body>
					<h3>'.$login.' a aimé une de vos photos!</h3>
					<a href="http://localhost:8080'.$base_url.'galery/photo/'.$photo_id.'">Voir</a>
					</body>
					</html>';
				$mail = $user_photo['email'];

				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'From: camagru@no-reply.com' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				mail($mail, "Notification Camagru", $message, $headers);

			}
			header('Location: '.$base_url.'galery/photo/'.$photo_id.'');
		}
	}
	public function del_like()
	{
		global $base_url;

		if (!$_SESSION['connect'])
		{
			Home::index();
			exit;
		}
		if ($_POST['submit'])
		{
			$like_id = $_POST['like_id'];
			$photo_id = $_POST['photo_id'];
			Likes_model::del_base_like($like_id);
			header('Location: '.$base_url.'galery/photo/'.$photo_id.'');
		}
	}
}
global $like;
$like = new Like;
