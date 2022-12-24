<?php
$lang = $viewConfig->get("lang");

if ($lang == "eng") {
?>

	<div class="row text-center items-center" style="width:100%; height:100vh">
		<div>
			<div class="my-3 title1">Access denied. Please sign in to continue</div>
			<div class="my-3 title4"><a href="home">Home page</a></div>
		</div>
	</div>


<?php
} else {
?>

	<div class="row text-center items-center w-100" style="width:100%; height:100vh">
		<div>
			<div class="my-3 title1">Доступ к странице закрыт. Требуется войти в систему</div>
			<div class="my-3 title4"><a href="home">Перейти на главную страницу</a></div>
		</div>
	</div>


<?php
}
?>