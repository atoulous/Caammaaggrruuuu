<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Camagru - Se connecter</title>
	<link rel="stylesheet" type="text/css" href="<?=$base_url?>ressources/css/style.css">
</head>
<body>
	<div id="header"><h1 style="font-style: italic">Camagru</h1></div>
	<div id="container">
	<form id="login" action="<?=$base_url?>user" method="post">
			<h3>Connexion</h3>
			<p style="color:#f3558e"><?echo "$alert"?><p>
			<p><input type="text" id="login" name="login" pattern=".[a-zA-Z0-9@._-]{1,}" title="2 caractères alphanumériques" value="<?=$login?>" placeholder="Login ou adresse mail" autofocus/></p>
			<p><input type="password" id="pwd" name="pwd" pattern=".[a-zA-Z0-9]{5,}" title="6 caractères alphanumériques" placeholder="Mot de passe"/></p>
			<p><input type="submit" name="submit" value="Se connecter"/></p>
		</form>
		<div style="text-align:center">
			<a href="<?=$base_url?>user/subscribe" title="Inscription" style="color: #333c4a";>S'inscrire ?</a></br>
			</br><small><a href="<?=$base_url?>user/reset_pwd" style="color: #333c4a">Mot de passe oublié ?</a></small>
		</div>
	</div>
<?include("views/footer_view.php");?>
