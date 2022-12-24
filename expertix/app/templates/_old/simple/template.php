<!doctype html>
<!--[if IE 9]><html class="ie ie9"><![endif]-->
<html lang="ru">

<head>
	<title><?= $viewConfig->getParam("title", "Страница проекта") ?></title>
	<base href="<?= $view->getBaseUrl() ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
</head>

<body>
	<?php
	require_once $viewConfig->getPagePath();
	?>
</body>
</html>