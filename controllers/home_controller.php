<?php
Class Home
{
	public function index()
	{
		global $base_url;

		if (!$_SESSION['connect'])
		{
			Login::index();
			exit;
		}
		else
		{
			//verifier si l'user existe encore
			echo ($_SESSION['alert']);
			$_SESSION['alert'] = NULL;
			include('views/header_view.php');
			include('views/home_view.php');
			include('views/footer_view.php');
		}
	}
}
global $home;
$home = new Home;
