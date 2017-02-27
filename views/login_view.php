<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Camagru - Se connecter</title>
	<!--<link rel="stylesheet" type="text/css" href="<?=$base_url?>ressources/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?=$base_url?>ressources/css/w3.css">-->
	<link rel="stylesheet" type="text/css" href="<?=$base_url?>ressources/css/style.css">
</head>
<body>
	<header>
	</header>
	<div class="container">
	<form id="login" action="<?=$base_url?>login" method="post">
			<h1>Connexion</h1>
			<p><?echo "$alert"?><p>
			<p><input type="text" id="login" name="login" pattern=".[a-zA-Z0-9]{1,}" value="<?=$login?>" placeholder="Login ou adresse mail" autofocus/></p>
			<p><input type="password" id="pwd" name="pwd" pattern=".[a-zA-Z0-9]{5,}" placeholder="Mot de passe"/></p>
			<p><input type="submit" name="submit" value="Se connecter"  aria-checked="false"/></p>
		</form>
		<p><a href="<?=$base_url?>login/subscribe" title="Inscription">S'inscrire ?</a></p>
		<small><a href="<?=$base_url?>login/reset">Mot de passe oublié ?</a></small>
	</div>
</body>
</html>
