<div id="container" style="text-align:center">
	<div id="camera">
		<video id="video"></video>
		<canvas id="canvas" ></canvas>
	</div>
	<div id="button">
		<button id="startbutton" disabled>Prendre une photo</button>
		<button id="deletebutton" disabled>Supprimer la photo</button>
		<button id="publishbutton" disabled>Publier la photo</button></p>
	</div>
</br>
	<div>
	<h3>Les filtres</h3>
		<ul>
<?php
foreach ($filters as $filter) {
	$name = str_replace(".png", "", $filter);
	echo '<li><img id="filters" onclick="add_filter(this)" src="'.$base_url.'ressources/filters/'.$filter.'" title="'.$name.'" /></li>';
}?>
		</ul>
	<h3>Les dernières photos</h3>
	<ul id="ul-photos" style="text-align:center">
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
		<a href=$href><img id='all'src='data:image/png;base64,$photo'></br>
		<span style='color:#4BB5C1'>$nb_likes $tmp,</span>
		<span style='color:#4BB5C1'>$nb_comments $tmp2</span>
		</a></li>";
}?>
	</ul>
	</div>
	<script>WebCam();</script>
</div>
