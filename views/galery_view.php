<div id="container">
<h3>Les photos de la communauté</h3>
	<ul>
<?php
foreach($photos as $img) {
	$name = $img['name'];
	$id = $img['id'];
	$photo = base64_encode(file_get_contents("ressources/photos/$name.png"));
	$href = $base_url."galery/photo/$id";
	$nb_likes = count(Likes_model::get_photo_likes($id));
	$nb_comments = count(Comments_model::get_photo_comments($id));
	$tmp = $nb_likes > 1 ? "likes" : "like";
	$tmp2 = $nb_comments > 1 ? "commentaires" : "commentaire";
	echo "<li>
		<a href=$href><img id='all'src='data:image/png;base64,$photo'>
		<span style='color:#4BB5C1'>$nb_likes $tmp,</span>
		<span style='color:#4BB5C1'>$nb_comments $tmp2</span>
		</a></li>";
}
?>
	</ul>
<h3>Vos photos</h3>
	<ul>
<?php
foreach($photos_user as $img) {
	$name = $img['name'];
	$id = $img['id'];
	$photo = base64_encode(file_get_contents("ressources/photos/$name.png"));
	$href = $base_url."galery/photo/$id";
	$nb_likes = count(Likes_model::get_photo_likes($id));
	$nb_comments = count(Comments_model::get_photo_comments($id));
	$tmp = $nb_likes > 1 ? "likes" : "like";
	$tmp2 = $nb_comments > 1 ? "commentaires" : "commentaire";
	echo "<li>
		<a href=$href><img id='user' src='data:image/png;base64,$photo'></br>
		<span style='color:#4BB5C1'>$nb_likes $tmp,</span>
		<span style='color:#4BB5C1'>$nb_comments $tmp2</span>
		</a></li>";
}
?>
	</ul>
</div>
<script></script>
