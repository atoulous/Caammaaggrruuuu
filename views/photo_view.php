<div id="container" style="text-align:center">
<h3>Photo de <a style="color:<?=$color?>" href=<?=$base_url.'user/list_users'?>><?=$photo_user_login?></a></h3>
<?php
	$name = $photo['name'];
	$extension = $photo['extension'];
	$id = $photo['id'];
	$img = base64_encode(file_get_contents("ressources/photos/$name.$extension"));
	$date = $photo['date'];
	if ($photo['user_id'] == $_SESSION['id'] || $_SESSION['admin'])
	{
		echo '<div id="del_photo" style="display:ruby-text-container">
		Publiée le '.$date.'
		<form id="form_delphoto" action="'.$base_url.'galery/del_photo" method="post">
		<input type="hidden" name="photo_id" value="'.$photo['id'].'"/>
		<input type="submit" id="submit_delcom" name="submit" title="Supprimer la photo" value="X"/>
		</form></div></br>';
	}
	else
		echo 'Publiée le '.$date.'</br></br>';
	echo '<img src="data:image/'.$extension.';base64,'.$img.'"></br>
		<span style="color:#3b5998">'.count($likes).' <3</span></br>';
	foreach($likes as $lik) {
		$usr = Users_model::get_user_infos($lik['user_id']);
		echo '<span style="color:#3b5998">'.$usr['login'].' aime ça</span></br>';
	}
	if (!$like)
		$action = ''.$base_url.'like/add_like';
	else
		$action= ''.$base_url.'like/del_like';
?>
	<form id="dellike" action="<?=$action?>" method="post">
		<input type="hidden" name="photo_user_id" value="<?=$photo_user_id?>"/>
		<input type="hidden" name="photo_id" value="<?=$photo_id?>"/>
		<input type="hidden" name="like_id" value="<?=$like['id']?>"/>
		<input type="submit" style="background:#3b5998;font-weight:bold" name="submit" title="like" value="<?=$like ? "J'aime plus" : "J'aime"?>">
	</form>

<!--<iframe src="https://www.facebook.com/plugins/share_button.php?href=http%3A%2F%2Flocalhost%3A8080%2F<?=$base_url?>%2Fgalery%2Fphoto%2F<?=$id?>&layout=button&size=small&mobile_iframe=true&width=73&height=20&appId" width="73" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe></br>

<a ref="http://twitter.com/share" class="twitter-share-button" data-count="vertical">Tweet</a></br></br>
<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
-->

<?
	foreach ($comments as $com)
	{
		if (!($user_comment = Users_model::get_user_infos($com['user_id'])))
			$user_comment['login'] = "Inconnu";
		$login_comment = $user_comment['login'];
		$text = $com['text'];
		$color = $login_comment == $_SESSION['login'] ? "#f3558e" : "#7dce94";
		$date = $com['date'];
		if ($user_comment['id'] == $_SESSION['id'] || $_SESSION['admin'])
		{
			echo '<div id="comment" style="display:ruby-text-container"><span style="font-weight:bold;color:'.$color.'">'.$login_comment.':</span> '.$text.'
			<form id="form_delcom" action="'.$base_url.'comment/del_comment" method="post">
			<input type="hidden" name="id_comment" value="'.$com['id'].'"/>
			<input type="hidden" name="photo_id" value="'.$photo['id'].'"/>
			<input type="submit" id="submit_delcom" name="submit" title="Supprimer le commentaire" value="X"/>
			</form><span style="font-size:small"> le '.$date.'</span></div></br>';
		}
		else
			echo "<div id='comment'><span style='font-weight:bold;color:$color'>$login_comment: </span><span> $text </span> <span style='font-size:small;margin-left:5%'> le $date </span></div>";
	}
?>
	<form id="addcom" action="<?=$base_url?>comment/add_comment" method="post"></br>
		<input type="text" required id="add_comment" name="text" pattern=".[a-zA-Z0-9():;@ ._]{1,}" placeholder="Votre commentaire..."/>
		<input type="hidden" name="photo_user_id" value="<?=$photo_user_id?>"/>
		<input type="hidden" name="photo_id" value="<?=$photo_id?>"/>
		<input type="submit" name="submit" title="Envoyer le commentaire" value="Envoyer"/>
	</form></br>
	<a href="<?=$base_url?>galery" title="Galerie" style="color: #333c4a">Retour à la galerie</a>
</div>
