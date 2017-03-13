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
			$_SESSION['alert'] = NULL;
			include('views/header_view.php');
			$filters = array_diff(scandir('ressources/filters'), array('..', '.'));
			$photos = Photos_model::get_all_photos();
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
			$filter['name'] = $_POST['filter'];
			$filter['top'] = $_POST['size-top'];
			$filter['left'] = $_POST['size-left'];
			$img_r = str_replace('data:image/png;base64,', '', $img);
			$img_r = str_replace(' ', '+', $img_r);
			$img_decode = base64_decode($img_r);
			$name = uniqid();
			file_put_contents("ressources/photos/$name.png", $img_decode);
			if ($_POST['filter'])
				Home::add_filter_photo($name, $filter);
			Photos_model::add_base_photo($name);
			$photos = Photos_model::get_all_photos();
			foreach ($photos as $photo) {
				if ($photo['name'] == $name)
					$id = $photo['id'];
			}
			$nb_likes = count(Likes_model::get_photo_likes($id));
			$nb_comments = count(Comments_model::get_photo_comments($id));
			$tmp = $nb_likes > 1 ? "likes" : "like";
			$tmp2 = $nb_comments > 1 ? "commentaires" : "commentaire";
			$href = $base_url."galery/photo/$id";
			$tab['href'] = $href;
			$tab['like'] = "$nb_likes $tmp, ";
			$tab['comment'] = "$nb_comments $tmp2";
			$tab['src'] = "ressources/photos/$name.png";
			echo json_encode($tab);
		}
	}

	public function add_filter_photo($name, $filter)
	{
		$src = imagecreatefrompng('ressources/filters/'.$filter['name'].'.png');
		$dst = imagecreatefrompng('ressources/photos/'.$name.'.png');
		$left = $filter['left'];
		$top = $filter['top'];
		imagecopy($dst, $src, $left, $top, 0, 0, 404, 304);
		imagepng($dst, 'ressources/photos/'.$name.'.png');
	}
}

global $home;
$home = new Home;
