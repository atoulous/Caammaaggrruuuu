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

		if (!$_SESSION['connect']) {
			User::index();
			exit;
		}
		if (!Users_model::checkifexists($_SESSION['login'], $_SESSION['email']))
			User::logout();
		else {
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

		if (!$_SESSION['connect'] || !$_POST)
		{
			Home::index();
			exit;
		}
		else if (($img = $_POST['img']) != 'false')
		{
			$filter['name'] = $_POST['filter'];
			$filter['top'] = $_POST['size-top'];
			$filter['left'] = $_POST['size-left'];
			$size = getimagesize($img);
			switch ($size['mime']) {
				case "image/gif":
					$extension = "gif";
					break;
				case "image/png":
					$extension = "png";
					break;
				case "image/jpeg":
					$extension = "jpeg";
					break;
			}
			if (!$extension)
				header("Location: $base_url");
			$img_r = str_replace('data:image/'.$extension.';base64,', '', $img);
			$img_r = str_replace(' ', '+', $img_r);
			$img_decode = base64_decode($img_r);
			$name = uniqid();
			if (!file_exists("ressources/photos"))
				mkdir("ressources/photos");
			file_put_contents("ressources/photos/$name.$extension", $img_decode);
			if ($_POST['filter'])
				Home::add_filter_photo($name, $extension, $filter);
			Photos_model::add_base_photo($name, $extension);
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
			$tab['src'] = "ressources/photos/$name.$extension";
			echo json_encode($tab);
		}
	}

	public function add_filter_photo($name, $extension, $filter)
	{
		if (!$_SESSION['connect'] || !$name || !$extension || !$filter)
		{
			Home::index();
			exit;
		}
		$width = 404;
		$height = 304;
		list($width_orig, $height_orig) = getimagesize('ressources/photos/'.$name.'.'.$extension.'');
		$ratio_orig = $width_orig/$height_orig;
		if ($width/$height > $ratio_orig) {
			$width = $height*$ratio_orig;
		} else {
			$height = $width/$ratio_orig; }
		$resize = imagecreatetruecolor($width, $height);
		$src = imagecreatefrompng('ressources/filters/'.$filter['name'].'.png');
		if ($extension == "png")
			$dst = imagecreatefrompng('ressources/photos/'.$name.'.'.$extension.'');
		else if ($extension == "jpeg")
			$dst = imagecreatefromjpeg('ressources/photos/'.$name.'.'.$extension.'');
		else if ($extension == "gif")
			$dst = imagecreatefromgif('ressources/photos/'.$name.'.'.$extension.'');
		else
			$dst = imagecreatetruecolor($width, $height);
		$left = $filter['left'];
		$top = $filter['top'];
		imagecopyresampled($resize, $dst, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		$extension != "gif" ? imagecopy($resize, $src, $left, $top, 0, 0, 402, 302) : 0;
		if ($extension == "png")
			imagepng($resize, 'ressources/photos/'.$name.'.png');
		else if ($extension == "jpeg")
			imagejpeg($resize, 'ressources/photos/'.$name.'.jpeg');
		else if ($extension == "gif") {
				$tempimage = imagecreatetruecolor($width, $height);
				// copy the 8-bit gif into the truecolor image
				imagecopy($tempimage, $resize, 0, 0, 0, 0, $width, $height);
				// copy the source_id int
				//imagecopymerge($resize, $src, $left, $top, 0, 0, 402, 302, 75);
				imagecopy($tempimage, $src, $left, $top, 0, 0,$width, $height);
				//imagecopy($resize, $src, $left, $top, 0, 0, 402, 302);
				imagegif($tempimage, 'ressources/photos/'.$name.'.gif');
		}
		imagedestroy($resize);
		imagedestroy($dst);
		imagedestroy($src);
	}
}

global $home;
$home = new Home;
