<!doctype html>
<!--[if IE 9]><html class="ie ie9"><![endif]-->
<html lang="ru">

<head>
	<title><?= $viewConfig->getParam("title", "Страница проекта") ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="description" content="<?= $viewConfig->getParam("view_description", "Страница проекта") ?>">

	<meta property="og:title" content="<?= $viewConfig->getParam("title", "Страница проекта") ?>">
	<meta property="og:type" content="<?= $viewConfig->getParam("view_meta_type", "") ?>">
	<meta property="og:url" content="<?= $viewConfig->getParam("view_meta_url", "") ?>">
	<meta property="og:image" content="<?= $viewConfig->getParam("view_meta_image", "") ?>">

	<base href="<?= $view->getBaseUrl() ?>" />


	<?php
	if ($view->checkParam("view_framework")) {
		require __DIR__ . "/../framework/" . $viewConfig->getParam("view_framework") . "_header.php";
	}
	?>



	<?php
	if ($view->checkParam("view_css_page")) {
		echo ('<link rel="stylesheet" href="css/' . $viewConfig->getParam("view_css_page") . '">');
	} else {
	?>

	<?php
	}
	?>

	<style>
		[v-cloak] {
			display: none;
		}
	</style>

	<?php
	if ($view->checkParam("view_header_custom")) {
		require $view->getIncludePath("view_header_custom");
	}
	?>

	<script src="js/expertix.js"></script>

</head>

