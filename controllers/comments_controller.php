<?php
Class Comment
{
	public function index()
	{
	}

	public function add_comment()
	{
		global $base_url;

		if ($_POST['submit'] && $_POST['text'])
		{
			$user_id = $_SESSION['id'];
			$photo_user_id = $_POST['photo_user_id'];
			$photo_id = $_POST['photo_id'];
			$text = $_POST['text'];
			if (Comments_model::add_base_comment($user_id, $photo_id, $photo_user_id, $text) && $_SESSION['id'] != $photo_user_id)
			{
				$user_photo = Users_model::get_user_infos($photo_user_id);
				$login = $_SESSION['login'];
				$message = '
					<html>
					<head>
					</head>
					<body>
					<h3>'.$login.' a commenté une de vos photos!</h3>
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
		else
			header('Location: '.$base_url.'galery/photo/'.$photo_id.'');
	}

	public function del_comment()
	{
		global $base_url;

		if ($_POST['submit'] && $_POST['id_comment'] && $_POST['photo_id'])
		{
			$id = $_POST['id_comment'];
			$photo_id = $_POST['photo_id'];
			Comments_model::del_base_comment($id);
			header('Location: '.$base_url.'galery/photo/'.$photo_id.'');
		}
		else
			header('Location: '.$base_url.'galery/photo/'.$photo_id.'');
	}
}

global $comment;
$comment = new Comment;
