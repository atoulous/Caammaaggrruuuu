<div id="container" style="text-align:center">
<h3>Photo de <?=$photo_user_login?></h3>
<?php
	$name = $photo['name'];
	$img = base64_encode(file_get_contents("ressources/photos/$name.png"));
	$date = $photo['date'];
	echo 'Publiée le '.$date.'</br>
		<img src="data:image/png;base64,'.$img.'"></br>
		<span style="color:#4BB5C1">'.count($likes).' <3</span></br>';
	foreach($likes as $lik) {
		$usr = Users_model::get_user_infos($lik['user_id']);
		echo '<span style="color:#4BB5C1">'.$usr['login'].' aime ça</span></br>';
	}
	if (!$like) {
		?><form id="addlike" action="<?=$base_url?>like/add_like" method="post"><?
	}
	if ($like) {
		?><form id="dellike" action="<?=$base_url?>like/del_like" method="post"><?
	}
?>
		<input type="hidden" name="photo_user_id" value="<?=$photo_user_id?>"/>
		<input type="hidden" name="photo_id" value="<?=$photo_id?>"/>
		<input type="hidden" name="like_id" value="<?=$like['id']?>"/>
		<input type="submit" style="background:#4BB5C1" name="submit" title="like" value="<?=$like ? "J'aime plus" : "J'aime"?>">
	</form></br>
<?
	foreach ($comments as $com)
	{
		if (!($user_comment = Users_model::get_user_infos($com['user_id'])))
			$user_comment['login'] = "Inconnu";
		$login_comment = $user_comment['login'];
		$text = $com['text'];
		$color = $login_comment == $_SESSION['login'] ? "#f3558e" : "#7dce94";
		if ($user_comment['id'] == $_SESSION['id'] || $_SESSION['admin'])
		{
			echo '<div id="comment" style="display:ruby-text-container"><span style="font-weight:bold;color:'.$color.'">'.$login_comment.':</span> '.$text.'
			<form id="form_delcom" action="'.$base_url.'comment/del_comment" method="post">
			<input type="hidden" name="id_comment" value="'.$com['id'].'"/>
			<input type="hidden" name="photo_id" value="'.$photo['id'].'"/>
			<input type="submit" id="submit_delcom" name="submit" title="Supprimer le commentaire" value="X"/>
			</form></div></br>';
		}
		else
			echo "<div id='comment'><span style='font-weight:bold;color:$color'>$login_comment:</span> $text</div>";
	}
?>
	<form id="addcom" action="<?=$base_url?>comment/add_comment" method="post"></br>
		<input type ="text" id="add_comment" name="text" pattern=".[a-zA-Z0-9@._-,;)(]{0,}" placeholder="Votre commentaire..."></input>
		<input type="hidden" name="photo_user_id" value="<?=$photo_user_id?>"/>
		<input type="hidden" name="photo_id" value="<?=$photo_id?>"/>
		<input type="submit" name="submit" title="Envoyer le commentaire" value="Envoyer"/>
	</form></br>
	<a href="<?=$base_url?>galery" title="Galerie" style="color: #333c4a">Retour à la galerie</a>
</div>
