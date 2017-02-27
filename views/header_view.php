<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Camagru</title>
	<link rel="stylesheet" type="text/css" href="<?=$base_url?>ressources/css/style.css"/>
	<script type="text/javascript" src="<?=$base_url?>views/webcam.js"></script>
</head>
<body>
	<header>
		<p>
			<?echo($_SESSION['login'])?>
			<a href="<?=$base_url?>login/logout">Se deconnecter</a>
		</p>
	</header>
