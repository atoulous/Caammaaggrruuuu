<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Camagru - Reset</title>
	<link rel="stylesheet" type="text/css" href="<?=$base_url?>ressources/css/style.css">
</head>
<body>
	<div id="header"><h1 style="font-style: italic">Camagru</h1></div>
	<div id="container">
	<form id="login" action="<?=$base_url?>user/reset_pwd" method="post">
			<h3>Réinitialiser son mot de passe</h3>
			<p style="color:#f3558e"><?echo "$alert"?><p>
			<p>Un mail vous sera envoyé<p>
			<p><input type="text" id="login" name="login" pattern=".[a-zA-Z0-9@._-]{1,}" title="2 caractères alphanumériques" value="<?=$login?>" placeholder="Login ou adresse mail" autofocus/></p>
			<p><input type="submit" name="submit" value="Envoyer l'email"/></p>
		</form>
		<div style="text-align:center">
			<a href="<?=$base_url?>user" title="Se connecter" style="color: #333c4a";>Enfaite si je l'ai</a></br>
		</div>
	</div>
<?include("views/footer_view.php");?>
