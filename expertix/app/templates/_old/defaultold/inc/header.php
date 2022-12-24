<!doctype html>
<!--[if IE 9]><html class="ie ie9"><![endif]-->
<html lang="ru">

<head>
	<title><?= $viewConfig->getParam("title", "Страница проекта") ?></title>
	<base href="<?= $view->getBaseUrl() ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="description" content="<?= $viewConfig->getParam("description", "Страница проекта") ?>">

	<meta property="og:title" content="<?= $viewConfig->getParam("title", "Страница проекта") ?>">
	<meta property="og:type" content="<?= $viewConfig->getParam("meta_type", "") ?>">
	<meta property="og:url" content="<?= $viewConfig->getParam("meta_url", "") ?>">
	<meta property="og:image" content="<?= $viewConfig->getParam("meta_image", "") ?>">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<!--link rel="stylesheet" href="css/vendor/bootstrap.css"-->
	<link rel="stylesheet" href="//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.css" />
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Manrope&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@1,800&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/main.css">

	<style>
		[v-cloak] {
			display: none;
		}
	</style>


</head>

<body>