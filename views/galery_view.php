<div id="container">
<h3>Les photos de la communauté</h3>
	<ul id="ul-all">
	<i id='back' onclick="load_back(0)" class="fa fa-chevron-left fa-4x"></i>
<?php
for ($i = $page; $i < $nb_photos_page; $i++) {
	if ($img = $photos[$i]) {
		$name = $img['name'];
		$id = $img['id'];
		$extension = $img['extension'];
		$photo = base64_encode(file_get_contents("ressources/photos/$name.$extension"));
		$href = $base_url."galery/photo/$id";
		$nb_likes = count(Likes_model::get_photo_likes($id));
		$nb_comments = count(Comments_model::get_photo_comments($id));
		$tmp = $nb_likes > 1 ? "likes" : "like";
		$tmp2 = $nb_comments > 1 ? "commentaires" : "commentaire";
		echo "<li id='li'>
			<a href=$href><img id='all'src='data:image/$extension;base64,$photo'></br>
			<span style='color:#4BB5C1'>$nb_likes $tmp,</span>
			<span style='color:#4BB5C1'>$nb_comments $tmp2</span>
			</a></li>";
	}
}
?>
	<i id='next' onclick="load_next(0)" class="fa fa-chevron-right fa-4x"></i>
	</ul>
<h3>Vos photos</h3>
	<ul id="ul-perso">
	<i id='back' onclick="load_back(0)" class="fa fa-chevron-left fa-4x"></i>
<?php
for ($i = $page; $i < $nb_photos_page; $i++) {
	if ($img = $photos[$i]) {
		$img = $photos_user[$i];
		$name = $img['name'];
		$id = $img['id'];
		$extension = $img['extension'];
		$photo = base64_encode(file_get_contents("ressources/photos/$name.$extension"));
		$href = $base_url."galery/photo/$id";
		$nb_likes = count(Likes_model::get_photo_likes($id));
		$nb_comments = count(Comments_model::get_photo_comments($id));
		$tmp = $nb_likes > 1 ? "likes" : "like";
		$tmp2 = $nb_comments > 1 ? "commentaires" : "commentaire";
		echo "<li id='li'>
			<a href=$href><img id='user' src='data:image/$extension;base64,$photo'></br>
			<span style='color:#4BB5C1'>$nb_likes $tmp,</span>
			<span style='color:#4BB5C1'>$nb_comments $tmp2</span>
			</a></li>";
	}
}
?>
	<i id='next_user' onclick="load_next_user(0)" class="fa fa-chevron-right fa-4x"></i>
	</ul>
</div>
<script></script>
