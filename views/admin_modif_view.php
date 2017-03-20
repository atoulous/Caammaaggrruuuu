<div id="container">
<h3>Compte de <?=$login?></h3>
	<form id="user_info" action="<?=$base_url?>user/admin_modif" method="post">
		<p style="color:#f3558e"><?echo "$alert"?><p>
		<p><input type="text" id="login" name="login" pattern=".[a-zA-Z0-9]{1,}" title="2 caractères minimum" value="<?=$login?>" placeholder="Login" autofocus/></p>
			<p><input type="text" id="email" name="email" value="<?=$email?>" pattern=".[a-zA-Z0-9-@._]{4,}" title="email valide" placeholder="Adresse mail"/></p>
			<p><input type="password" id="pwd" name="pwd" pattern=".[a-zA-Z0-9]{5,}" title="6 caractères minimum" placeholder="Nouveau mot de passe"/></p>
			<p><input type="password" id="pwd2" name="pwd2" pattern=".[a-zA-Z0-9]{5,}" title="6 caractères minimum" placeholder="Confirmez le mot de passe"/></p>
			<p><input type="hidden" name="user_id" value="<?=$user_id?>"></p>
			<p><input type="submit" name="submit" value="Modifier"/></p>
		</form>
		<p style="text-align:center"><a style="color:#333c4a;" href="<?=$base_url?>" title="Accueil Camagru">Retour</a></p>
		<form onsubmit="return confirm('Supression du compte <?=$login?>. Etes-vous sur?')" action="<?=$base_url?>user/delete_user" method="post">
			<input type="hidden" name="user_id" value="<?=$user_id?>">
			<input style="background:#f3558e;" type="submit" name="submit" value="Supprimer son compte">
		</form>
</div>
