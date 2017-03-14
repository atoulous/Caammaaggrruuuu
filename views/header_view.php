<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Camagru</title>
	<link rel="stylesheet" type="text/css" href="<?=$base_url?>ressources/css/style.css"/>
	<script type="text/javascript" src="<?=$base_url?>views/webcam.js"></script>
</head>
<body>
	<div id="header">
	<h1><a style="color:#7dce94" href="<?=$base_url?>">Camagru</a></h1>
		<div id="menu">
			<a href="<?=$base_url?>">Accueil</a>
			<a href="<?=$base_url?>galery">Galerie</a>
			<a href="<?=$base_url?>user/list_users">Communauté</a>
		</div>
		<div id="account">
			<span style="color:#f3558e;font-size:3vmin"><?echo($_SESSION['login'])?></span>
			<a href="<?=$base_url?>user/user_infos">Mon compte</a>
			<a href="<?=$base_url?>user/logout">Se deconnecter</a>
		</div>
	</div>
