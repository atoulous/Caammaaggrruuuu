<!doctype html>
<?php?>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Camagru - Inscription</title>
	<link rel="stylesheet" type="text/css" href="<?=$base_url?>ressources/css/style.css">
</head>
<body>
	<div id="header"><h1 style="font-style: italic">Camagru</h1></div>
	<div id="container">
		<form id="subscribe" action="<?=$base_url?>user/subscribe" method="post">
			<h3>Inscription</h3>
			<p style="color:#f3558e"><?echo "$alert"?><p>
			<p><input type="text" id="login" name="login" pattern=".[a-zA-Z0-9]{1,}" title="2 caractères alphanumériques minimum" value="<?=$login?>" placeholder="Login" autofocus/></p>
			<p><input type="text" id="email" name="email" value="<?=$email?>" pattern=".[a-zA-Z0-9@._-]{2,}" title="email valide" placeholder="Adresse mail"/></p>
			<p><input type="password" id="pwd" name="pwd" pattern=".[a-zA-Z0-9]{5,}" title="6 caractères alphanumériques minimum" placeholder="Mot de passe"/></p>
			<p><input type="password" id="pwd2" name="pwd2" pattern=".[a-zA-Z0-9]{5,}" title="6 caractères alphanumériques minimum" placeholder="Confirmez le mot de passe"/></p>
			<p><input type="submit" name="submit" value="S'inscrire"/></p>
		</form>
		<div style="text-align:center">
			<a href="<?=$base_url?>user" title="Se connecter" style="color: #333c4a">Déjà inscrit ?</a>
		</div>
	</div>
<?include("views/footer_view.php");?>
