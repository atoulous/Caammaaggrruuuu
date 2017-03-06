<?php
class galery
{
	public function index()
	{
		global $DB_NAME;
		global $base_url;

		if (!$_SESSION['connect'])
		{
			Login::index();
			exit;
		}
		else
		{
			include('views/header_view.php');
			$photos = Photos_model::get_all_photos();
			$photos_user = Photos_model::get_user_photos($_SESSION['id']);
			include('views/galery_view.php');
			include('views/footer_view.php');
		}
	}

	public function photo()
	{
		global $DB_NAME;
		global $base_url;

		$url = explode('/', $_SERVER[REQUEST_URI]);
		$photo_id = $url[4];
		include('views/header_view.php');
		$photo = Photos_model::get_photo($photo_id);
		if (!($user = Users_model::get_user_infos($photo['user_id'])))
			$user['login'] = "Inconnu";
		$photo_user_login = $user['login'];
		$photo_user_id = $user['id'];
		$comments = Comments_model::get_photo_comments($photo_id);
		$likes = Likes_model::get_photo_likes($photo_id);
		$like = Likes_model::get_user_like($photo_id, $_SESSION['id']);
		include('views/photo_view.php');
		include('views/footer_view.php');
	}
}

global $galery;
$galery = new Galery;
