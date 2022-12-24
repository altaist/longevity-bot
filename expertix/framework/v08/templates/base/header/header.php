<!doctype html>
<!--[if IE 9]><html class="ie ie9"><![endif]-->
<html lang="ru">

<head>
	<title><?= $viewConfig->getParam("title", "") ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<meta name="description" content="<?= $viewConfig->getParam("description", "") ?>">

	<meta property="og:title" content="<?= $viewConfig->getParam("title", "") ?>">
	<meta property="og:type" content="<?= $viewConfig->getParam("view_meta_type", "") ?>">
	<meta property="og:url" content="<?= $viewConfig->getParam("view_meta_url", "") ?>">
	<meta property="og:image" content="<?= $viewConfig->getParam("view_meta_image", "") ?>">

	<base href="<?= $viewConfig->getBaseUrl() ?>" />


	<?php
	require $viewConfig->getTemplateFrameworkPath("view_framework", "none", "header");
	/*	
	if ($viewConfig->checkParam("view_framework_header")) {
		require $viewConfig->getIncludePathWithParent("view_framework_header");
	} else {
		if ($viewConfig->checkParam("view_framework")) {
			require __DIR__ . "/../framework/" . $viewConfig->getParam("view_framework") . "_header.php";
		}
	}
*/
	?>


	<style>
		[v-cloak] {
			display: none;
		}
	</style>

	<?php
	require $viewConfig->getTemplateIncPath("view_header_custom", "");
	/*
	if ($viewConfig->checkParam("view_header_custom")) {
		require $viewConfig->getIncludePath("view_header_custom");
	}
	*/
	?>



</head>