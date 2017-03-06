<div id="container" style="text-align:center">
<h3>Les Camagruniens</h3>
	<ul style="display: inline">
<?php
foreach ($users as $usr) {
	$id = $usr['id'];
	$login = $usr['login'];
	$email = $usr['email'];
	$date = $usr['date'];
	$admin = $usr['admin'] ? "ADMINISTRATOR" : '';
	$color = $login == $_SESSION['login'] ? "#f3558e" : "#7dce94";
	$href = $base_url."user/user_infos/$id";
	echo '<li><a id="usr" style="color:'.$color.'" href="'.$href.'">'.$usr['login'].' </br> '.$email.' </br> Inscrit depuis le '.$date.' </br> '.$admin.'</a></li></br>';
}
?>
	</ul>
</div>
