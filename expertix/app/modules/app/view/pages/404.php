<?php
$lang = $viewConfig->get("lang");

if ($lang == "eng") {
?>
	<div class="row text-center items-center" style="height:100vh">
		<div>
			<h2>Requested page not found</h2>
			<div class="my-3 title4"><a href="home">Home page</a></div>
		</div>
	</div>
<?php
} else {
?>

	<div class="row text-center items-center" style="height:100vh">
		<div>
			<h2>Запрошенный ресурс не найден</h2>
			<div class="my-3 title4"><a href="home">Перейти на главную страницу</a></div>
		</div>
	</div>
<?php
}
?>