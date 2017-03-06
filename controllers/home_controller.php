<?php
Class Home
{
	function __construct()
	{
		require_once('models/photos_model.php');
		require_once('models/comments_model.php');
		require_once('models/likes_model.php');
	}
	public function index()
	{
		global $base_url;

		if (!$_SESSION['connect'])
		{
			User::index();
			exit;
		}
		else
		{
			//verifier si l'user existe encore?
			echo ($_SESSION['alert']);
			$_SESSION['alert'] = NULL;
			include('views/header_view.php');
			include('views/home_view.php');
			include('views/footer_view.php');
		}
	}

	public function add_photo()
	{
		global $base_url;
		global $photos_model;
		global $DB_NAME;

		if (!$_SESSION['connect'])
		{
			Login::index();
			exit;
		}
		else if (($img = $_POST['img']) != 'false')
		{
			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$img_decode = base64_decode($img);
			$name = uniqid();
			file_put_contents("ressources/photos/$name.png", $img_decode);
			if ($photos_model->add_base_photo($name))
				echo "Photo $name add to $DB_NAME\n";
		}
	}
}

global $home;
$home = new Home;
