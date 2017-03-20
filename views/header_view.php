<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Camagru</title>
	<link rel="stylesheet" type="text/css" href="<?=$base_url?>ressources/css/style.css"/>
	<link rel="stylesheet" type="text/css" href="<?=$base_url?>ressources/css/font-awesome.css"/>
	<script type="text/javascript" src="<?=$base_url?>views/webcam.js"></script>
</head>
<body>
	<div id="header">
	<a style="" href="<?=$base_url?>"><h1 style="font-style:italic;">Camagru</h1></a>
		<div id="menu">
			<a href="<?=$base_url?>">Accueil</a>
			<a href="<?=$base_url?>galery">Galerie</a>
			<a href="<?=$base_url?>user/list_users">Communauté</a>
		</div>
		<div id="account">
			<a title="Mon compte" href="<?=$base_url?>user/user_infos">
				<span style="color:#f3558e;"><?echo($_SESSION['login'])?></span></a>
			<a href="<?=$base_url?>user/logout">Se deconnecter</a>
		</div>
	</div>
