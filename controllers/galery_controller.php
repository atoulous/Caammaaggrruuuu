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
			$nb_photos = count($photos);
			$nb_photos_page = 4;
			$page = 0;
			$nb_pages = ceil($nb_photos / $nb_photos_page);
			$photos_user = Photos_model::get_user_photos($_SESSION['id']);
			include('views/galery_view.php');
			include('views/footer_view.php');
		}
	}

	public function load_next()
	{
		global $base_url;

		if ($_POST && $_SESSION['connect'])
		{
			$i = $_POST['i'];
			$photos = Photos_model::get_all_photos();
			$nb_photos = count($photos);
			$nb_photos_page = 4;
			$nb_pages = ceil($nb_photos / $nb_photos_page);
			$page += $i;
			$tab['photos'] = $photos;
			$yo = 0;
			foreach ($photos as $photo) {
				$id = $photo['id'];
				$nb_likes = count(Likes_model::get_photo_likes($id));
				$nb_comments = count(Comments_model::get_photo_comments($id));
				$tmp = $nb_likes > 1 ? "likes" : "like";
				$tmp2 = $nb_comments > 1 ? "commentaires" : "commentaire";
				$tab['photos'][$yo]['like'] = "$nb_likes $tmp, ";
				$tab['photos'][$yo]['comment'] = "$nb_comments $tmp2";
				$yo++;
			}
			$tab['i'] = $page;
			$tab['nb_photos_page'] = $nb_photos_page;
			$tab['nb_photos'] = $nb_photos;
			$tab['href'] = $base_url."galery/photo/";
			echo json_encode($tab);
		}
	}
	
	public function load_next_user()
	{
		global $base_url;

		if ($_POST && $_SESSION['connect'])
		{
			$i = $_POST['i'];
			$photos_user = Photos_model::get_user_photos($_SESSION['id']);
			$nb_photos = count($photos_user);
			$nb_photos_page = 4;
			$nb_pages = ceil($nb_photos / $nb_photos_page);
			$page += $i;
			$tab['photos'] = $photos_user;
			$yo = 0;
			foreach ($photos_user as $photo) {
				$id = $photo['id'];
				$nb_likes = count(Likes_model::get_photo_likes($id));
				$nb_comments = count(Comments_model::get_photo_comments($id));
				$tmp = $nb_likes > 1 ? "likes" : "like";
				$tmp2 = $nb_comments > 1 ? "commentaires" : "commentaire";
				$tab['photos'][$yo]['like'] = "$nb_likes $tmp, ";
				$tab['photos'][$yo]['comment'] = "$nb_comments $tmp2";
				$yo++;
			}
			$tab['i'] = $page;
			$tab['nb_photos_page'] = $nb_photos_page;
			$tab['nb_photos'] = $nb_photos;
			$tab['href'] = $base_url."galery/photo/";
			echo json_encode($tab);
		}
	}

	/*public function load_back()
	{
		global $base_url;

		if ($_POST && $_SESSION['connect'])
		{
			$i = $_POST['i'];
			$photos = Photos_model::get_all_photos();
			$nb_photos = count($photos);
			$nb_photos_page = 4;
			$nb_pages = ceil($nb_photos / $nb_photos_page);
			$photos_user = Photos_model::get_user_photos($_SESSION['id']);
			$page -= $i;
			$tab['photos'] = $photos;
			$yo = 0;
			foreach ($photos as $photo) {
				$id = $photo['id'];
				$nb_likes = count(Likes_model::get_photo_likes($id));
				$nb_comments = count(Comments_model::get_photo_comments($id));
				$tmp = $nb_likes > 1 ? "likes" : "like";
				$tmp2 = $nb_comments > 1 ? "commentaires" : "commentaire";
				$tab['photos'][$yo]['like'] = "$nb_likes $tmp, ";
				$tab['photos'][$yo]['comment'] = "$nb_comments $tmp2";
				$yo++;
			}
			$tab['i'] = $page;
			$tab['nb_photos_page'] = $nb_photos_page;
			$tab['nb_photos'] = $nb_photos;
			$tab['href'] = $base_url."galery/photo/";
			echo json_encode($tab);
		}
	}*/
	
/*	public function index()
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
 */
	public function photo()
	{
		global $DB_NAME;
		global $base_url;

		$url = explode('/', $_SERVER[REQUEST_URI]);
		if (!$url[4])
			header('Location: '.$base_url.'galery');

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
		$color = $_SESSION['id'] == $photo_user_id ? "#f3558e" : "#7dce94";
		include('views/photo_view.php');
		include('views/footer_view.php');
	}

	public function del_photo()
	{
		global $base_url;

		if ($_POST['submit'])
		{
			$photo_id = $_POST['photo_id'];
			Photos_model::del_base_photo($photo_id);
			header('Location: '.$base_url.'galery');
		}
	}
}

global $galery;
$galery = new Galery;
