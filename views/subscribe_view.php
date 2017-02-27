<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Camagru - Inscription</title>
	<!--<link rel="stylesheet" type="text/css" href="<?=$base_url?>ressources/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?=$base_url?>ressources/css/w3.css">-->
	<link rel="stylesheet" type="text/css" href="<?=$base_url?>ressources/css/style.css">
</head>
<body>
	<header>
	</header>
	<div class="container">
		<form id="subscribe" action="<?=$base_url?>login/subscribe" method="post">
			<h1>Inscription</h1>
			<p><?echo "$alert"?><p>
			<p><input type="text" id="login" name="login" pattern=".[a-zA-Z0-9]{1,}" title="2 caractères minimum" value="<?=$login?>" placeholder="Login" autofocus/></p>
			<p><input type="text" id="email" name="email" value="<?=$email?>" placeholder="Adresse mail"/></p>
			<p><input type="password" id="pwd" name="pwd" pattern=".[a-zA-Z0-9]{5,}" title="6 caractères minimum" placeholder="Mot de passe"/></p>
			<p><input type="password" id="pwd2" name="pwd2" placeholder="Confirmez le mot de passe"/></p>
			<p><input type="submit" name="submit" value="S'inscrire"/></p>
		</form>
		<p><a href="<?=$base_url?>login" title="Se connecter">Déjà inscrit ?</a></p>
	</div>
</body>
</html>
